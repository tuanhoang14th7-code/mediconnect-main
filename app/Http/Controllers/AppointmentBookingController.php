<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\AppointmentHistory;
use App\Models\DoctorAppointmentSlot;
use App\Notifications\AppointmentBookedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class AppointmentBookingController extends Controller
{
    // Show booking confirmation page
    public function confirm($slotId)
    {
        $slot = DoctorAppointmentSlot::with([
            'doctorAssignment.doctor.user',
            'doctorAssignment.facilitySpecialization.facility.city',
            'doctorAssignment.facilitySpecialization.specialization',
        ])->findOrFail($slotId);

        // Slot must still be available
        if ($slot->status !== 'Available') {

            return redirect(
                '/doctors/' . $slot->doctor_assignment_id
            )->with(
                'booking_error',
                'This appointment slot is no longer available.'
            );
        }

        // Do not allow booking past time
        $slotStart = Carbon::parse(
            $slot->slot_date->format('Y-m-d')
            . ' '
            . $slot->start_time
        );

        if ($slotStart->lte(now())) {

            return redirect(
                '/doctors/' . $slot->doctor_assignment_id
            )->with(
                'booking_error',
                'This appointment slot has already passed.'
            );
        }

        $user = Auth::user();

        return view(
            'patient.PatientBookingConfirm',
            compact('slot', 'user')
        );
    }


    // Create appointment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slot_id' => [
                'required',
                'integer',
                'exists:doctor_appointment_slots,id',
            ],

            'examination_reason' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'symptoms' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $user = Auth::user();


        $appointment = DB::transaction(function () use (
            $validated,
            $user
        ) {

            /*
             * Lock the slot while creating appointment.
             * This prevents two patients booking
             * the same slot at the same time.
             */
            $slot = DoctorAppointmentSlot::where(
                    'id',
                    $validated['slot_id']
                )
                ->lockForUpdate()
                ->firstOrFail();


            // Check again inside transaction
            if ($slot->status !== 'Available') {

                throw ValidationException::withMessages([
                    'slot_id' =>
                        'This appointment slot has just been booked. Please choose another slot.',
                ]);
            }


            $slotStart = Carbon::parse(
                $slot->slot_date->format('Y-m-d')
                . ' '
                . $slot->start_time
            );


            if ($slotStart->lte(now())) {

                throw ValidationException::withMessages([
                    'slot_id' =>
                        'This appointment slot has already passed.',
                ]);
            }


            $slot->load([
                'doctorAssignment.doctor',
                'doctorAssignment.facilitySpecialization',
            ]);


            $assignment = $slot->doctorAssignment;


            if (
                !$assignment ||
                $assignment->status !== 'Active' ||
                !$assignment->doctor ||
                $assignment->doctor->status !== 'Active' ||
                !$assignment->facilitySpecialization ||
                $assignment->facilitySpecialization->status !== 'Active'
            ) {

                throw ValidationException::withMessages([
                    'slot_id' =>
                        'This doctor is currently unavailable for booking.',
                ]);
            }


            // Generate unique appointment number
            $appointmentNumber =
                'APT-'
                . now()->format('Y')
                . '-'
                . strtoupper(Str::random(8));


            // Create appointment
            $appointment = Appointments::create([
                'appointment_number' =>
                    $appointmentNumber,

                'patient_user_id' =>
                    $user->id,

                'facility_specialization_id' =>
                    $assignment->facility_specialization_id,

                'doctor_assignment_id' =>
                    $assignment->id,

                'slot_id' =>
                    $slot->id,

                // Snapshot patient information
                'patient_name' =>
                    $user->name,

                'patient_email' =>
                    $user->email,

                'patient_phone' =>
                    $user->number,

                // Appointment time comes ONLY from slot
                'appointment_date' =>
                    $slot->slot_date,

                'start_time' =>
                    $slot->start_time,

                'end_time' =>
                    $slot->end_time,

                'examination_reason' =>
                    $validated['examination_reason'] ?? null,

                'symptoms' =>
                    $validated['symptoms'] ?? null,

                'status' =>
                    'Pending',

                'booked_at' =>
                    now(),
            ]);


            // Mark selected slot as booked
            $slot->status = 'Booked';
            $slot->held_at = null;
            $slot->booked_at = now();
            $slot->save();


            // Create appointment history
            AppointmentHistory::create([
                'appointment_id' =>
                    $appointment->id,

                'changed_by_user_id' =>
                    $user->id,

                'action' =>
                    'Created',

                'old_status' =>
                    null,

                'new_status' =>
                    'Pending',

                'old_doctor_assignment_id' =>
                    null,

                'new_doctor_assignment_id' =>
                    $assignment->id,

                'old_slot_id' =>
                    null,

                'new_slot_id' =>
                    $slot->id,

                'note' =>
                    'Appointment request created by patient.',
            ]);


            return $appointment;
        });

        $user->notify(
            new AppointmentBookedNotification(
                $appointment
            )
        );


        return redirect(
            '/doctors/' . $appointment->doctor_assignment_id
        )->with([
            'booking_success' =>
                'Appointment booked successfully.',

            'appointment_number' =>
                $appointment->appointment_number,
        ]);
    }
}