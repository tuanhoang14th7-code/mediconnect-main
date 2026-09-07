<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\AppointmentHistory;
use App\Models\DoctorAppointmentSlot;
use App\Notifications\AppointmentRescheduledNotification;
use App\Notifications\AppointmentCancelledNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AppointmentManagementController extends Controller
{
    // Show reschedule page
    public function rescheduleForm($id)
    {
        $appointment = Appointments::with([
            'doctorAssignment.doctor.user',
            'doctorAssignment.facilitySpecialization.facility.city',
            'doctorAssignment.facilitySpecialization.specialization',
            'slot',
        ])
        ->where('patient_user_id', Auth::id())
        ->findOrFail($id);


        // Only Pending or Confirmed appointments can be rescheduled
        if (!in_array(
            $appointment->status,
            ['Pending', 'Confirmed']
        )) {
            return redirect()
                ->route(
                    'patient.appointments.show',
                    $appointment->id
                )
                ->with(
                    'error',
                    'This appointment cannot be rescheduled.'
                );
        }


        // Do not reschedule appointments that already passed
        $appointmentStart = Carbon::parse(
            $appointment->appointment_date->format('Y-m-d')
            . ' '
            . $appointment->start_time
        );

        if ($appointmentStart->lte(now())) {
            return redirect()
                ->route(
                    'patient.appointments.show',
                    $appointment->id
                )
                ->with(
                    'error',
                    'Past appointments cannot be rescheduled.'
                );
        }


        return view(
            'patient.PatientAppointmentReschedule',
            compact('appointment')
        );
    }


    // Process reschedule
    public function reschedule(Request $request, $id)
    {
        $validated = $request->validate([
            'slot_id' => [
                'required',
                'integer',
                'exists:doctor_appointment_slots,id',
            ],
        ]);


        $appointment = DB::transaction(function () use (
            $validated,
            $id
        ) {

            /*
             * Lock appointment first
             * to prevent simultaneous updates.
             */
            $appointment = Appointments::where(
                    'patient_user_id',
                    Auth::id()
                )
                ->where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();


            if (!in_array(
                $appointment->status,
                ['Pending', 'Confirmed']
            )) {
                throw ValidationException::withMessages([
                    'slot_id' =>
                        'This appointment can no longer be rescheduled.',
                ]);
            }


            $oldStatus =
                $appointment->status;

            $oldSlotId =
                $appointment->slot_id;

            $oldAssignmentId =
                $appointment->doctor_assignment_id;


            // Lock selected new slot
            $newSlot = DoctorAppointmentSlot::where(
                    'id',
                    $validated['slot_id']
                )
                ->lockForUpdate()
                ->firstOrFail();


            // New slot must belong to the same doctor assignment
            if (
                $newSlot->doctor_assignment_id !=
                $appointment->doctor_assignment_id
            ) {
                throw ValidationException::withMessages([
                    'slot_id' =>
                        'The selected slot does not belong to this doctor.',
                ]);
            }


            // New slot must still be available
            if ($newSlot->status !== 'Available') {
                throw ValidationException::withMessages([
                    'slot_id' =>
                        'This slot is no longer available. Please choose another time.',
                ]);
            }


            // New slot must be in the future
            $newSlotStart = Carbon::parse(
                $newSlot->slot_date->format('Y-m-d')
                . ' '
                . $newSlot->start_time
            );

            if ($newSlotStart->lte(now())) {
                throw ValidationException::withMessages([
                    'slot_id' =>
                        'The selected appointment time has already passed.',
                ]);
            }


            /*
             * Release old slot.
             */
            if ($oldSlotId) {

                $oldSlot = DoctorAppointmentSlot::where(
                        'id',
                        $oldSlotId
                    )
                    ->lockForUpdate()
                    ->first();

                if ($oldSlot) {

                    $oldSlot->status =
                        'Available';

                    $oldSlot->booked_at =
                        null;

                    $oldSlot->held_at =
                        null;

                    $oldSlot->save();
                }
            }


            /*
             * Book new slot.
             */
            $newSlot->status =
                'Booked';

            $newSlot->held_at =
                null;

            $newSlot->booked_at =
                now();

            $newSlot->save();


            /*
             * Update appointment.
             *
             * After a Patient changes the schedule,
             * appointment returns to Pending
             * so the new time can be confirmed again.
             */
            $appointment->slot_id =
                $newSlot->id;

            $appointment->appointment_date =
                $newSlot->slot_date;

            $appointment->start_time =
                $newSlot->start_time;

            $appointment->end_time =
                $newSlot->end_time;

            $appointment->status =
                'Pending';

            $appointment->confirmed_at =
                null;

            $appointment->save();


            /*
             * Record history.
             */
            AppointmentHistory::create([
                'appointment_id' =>
                    $appointment->id,

                'changed_by_user_id' =>
                    Auth::id(),

                'action' =>
                    'Adjusted',

                'old_status' =>
                    $oldStatus,

                'new_status' =>
                    'Pending',

                'old_doctor_assignment_id' =>
                    $oldAssignmentId,

                'new_doctor_assignment_id' =>
                    $appointment->doctor_assignment_id,

                'old_slot_id' =>
                    $oldSlotId,

                'new_slot_id' =>
                    $newSlot->id,

                'note' =>
                    'Appointment rescheduled by patient.',
            ]);
            return $appointment;
        });

        Auth::user()->notify(
            new AppointmentRescheduledNotification(
                $appointment
            )
        );


        return redirect()
            ->route(
                'patient.appointments.show',
                $id
            )
            ->with(
                'success',
                'Appointment rescheduled successfully.'
            );
    }

    // Show cancel appointment page
    public function cancelForm($id)
    {
        $appointment = Appointments::with([
            'doctorAssignment.doctor.user',
            'doctorAssignment.facilitySpecialization.facility',
            'doctorAssignment.facilitySpecialization.specialization',
            'slot',
        ])
        ->where('patient_user_id', Auth::id())
        ->findOrFail($id);


        // Only Pending or Confirmed appointments can be cancelled
        if (!in_array(
            $appointment->status,
            ['Pending', 'Confirmed']
        )) {
            return redirect()
                ->route(
                    'patient.appointments.show',
                    $appointment->id
                )
                ->with(
                    'error',
                    'This appointment cannot be cancelled.'
                );
        }


        // Past appointments cannot be cancelled
        $appointmentStart = Carbon::parse(
            $appointment->appointment_date->format('Y-m-d')
            . ' '
            . $appointment->start_time
        );


        if ($appointmentStart->lte(now())) {
            return redirect()
                ->route(
                    'patient.appointments.show',
                    $appointment->id
                )
                ->with(
                    'error',
                    'Past appointments cannot be cancelled.'
                );
        }


        return view(
            'patient.PatientAppointmentCancel',
            compact('appointment')
        );
    }

    // Cancel appointment
    public function cancel(Request $request, $id)
    {
        $validated = $request->validate([
            'cancellation_reason' => [
                'required',
                'string',
                'max:500',
            ],
        ]);


        $appointment = DB::transaction(function () use (
            $validated,
            $id
        ) {

            // Lock appointment to prevent simultaneous changes
            $appointment = Appointments::where(
                    'patient_user_id',
                    Auth::id()
                )
                ->where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();


            // Check status again inside transaction
            if (!in_array(
                $appointment->status,
                ['Pending', 'Confirmed']
            )) {
                throw ValidationException::withMessages([
                    'cancellation_reason' =>
                        'This appointment can no longer be cancelled.',
                ]);
            }


            // Check appointment time again
            $appointmentStart = Carbon::parse(
                $appointment->appointment_date->format('Y-m-d')
                . ' '
                . $appointment->start_time
            );


            if ($appointmentStart->lte(now())) {
                throw ValidationException::withMessages([
                    'cancellation_reason' =>
                        'Past appointments cannot be cancelled.',
                ]);
            }


            $oldStatus =
                $appointment->status;

            $oldSlotId =
                $appointment->slot_id;

            $assignmentId =
                $appointment->doctor_assignment_id;


            /*
            * Release booked slot
            */
            if ($oldSlotId) {

                $slot = DoctorAppointmentSlot::where(
                        'id',
                        $oldSlotId
                    )
                    ->lockForUpdate()
                    ->first();


                if ($slot) {

                    $slot->status =
                        'Available';

                    $slot->booked_at =
                        null;

                    $slot->held_at =
                        null;

                    $slot->save();
                }
            }


            /*
            * Cancel appointment
            */
            $appointment->status =
                'Cancelled';

            $appointment->cancellation_reason =
                $validated['cancellation_reason'];

            $appointment->cancelled_at =
                now();

            $appointment->save();


            /*
            * Record appointment history
            */
            AppointmentHistory::create([
                'appointment_id' =>
                    $appointment->id,

                'changed_by_user_id' =>
                    Auth::id(),

                'action' =>
                    'Cancelled',

                'old_status' =>
                    $oldStatus,

                'new_status' =>
                    'Cancelled',

                'old_doctor_assignment_id' =>
                    $assignmentId,

                'new_doctor_assignment_id' =>
                    $assignmentId,

                'old_slot_id' =>
                    $oldSlotId,

                'new_slot_id' =>
                    $oldSlotId,

                'note' =>
                    Str::limit(
                        'Appointment cancelled by patient. Reason: '
                        . $validated['cancellation_reason'],
                        500
                    ),
            ]);
            return $appointment;
        });
        Auth::user()->notify(
            new AppointmentCancelledNotification(
                $appointment
            )
        );


        return redirect()
            ->route(
                'patient.appointments.show',
                $id
            )
            ->with(
                'success',
                'Appointment cancelled successfully.'
            );
    }
}