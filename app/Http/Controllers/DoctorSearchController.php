<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Facility;
use App\Models\Specialization;
use App\Models\FacilitySpecialization;
use App\Models\DoctorAssignment;
use App\Models\DoctorAppointmentSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorSearchController extends Controller
{
    // Search page
    public function index()
    {
        $cities = City::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view(
            'patient.PatientDoctorSearch',
            compact('cities')
        );
    }


    // Get facilities by city
    public function getFacilities($cityId)
    {
        $facilities = Facility::where('city_id', $cityId)
            ->where('status', 'Active')
            ->whereHas('facilitySpecializations', function ($query) {

                $query->where('status', 'Active')
                    ->whereHas('doctorAssignments', function ($assignment) {

                        $assignment->where('status', 'Active')
                            ->whereHas('doctor', function ($doctor) {

                                $doctor->where('status', 'Active');
                            });
                    });
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($facilities);
    }


    // Get specializations available at selected facility
    public function getSpecializations($facilityId)
    {
        $specializations = Specialization::where('status', 'Active')
            ->whereHas(
                'facilitySpecializations',
                function ($query) use ($facilityId) {

                    $query->where('facility_id', $facilityId)
                        ->where('status', 'Active')
                        ->whereHas(
                            'doctorAssignments',
                            function ($assignment) {

                                $assignment
                                    ->where('status', 'Active')
                                    ->whereHas(
                                        'doctor',
                                        function ($doctor) {

                                            $doctor->where(
                                                'status',
                                                'Active'
                                            );
                                        }
                                    );
                            }
                        );
                }
            )
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($specializations);
    }


    // Get doctors by facility + specialization
    public function getDoctors(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        $facilitySpecialization =
            FacilitySpecialization::where(
                'facility_id',
                $validated['facility_id']
            )
            ->where(
                'specialization_id',
                $validated['specialization_id']
            )
            ->where('status', 'Active')
            ->first();

        if (!$facilitySpecialization) {
            return response()->json([]);
        }

        $assignments = DoctorAssignment::with('doctor.user')
            ->where(
                'facility_specialization_id',
                $facilitySpecialization->id
            )
            ->where('status', 'Active')
            ->whereHas('doctor', function ($query) {
                $query->where('status', 'Active');
            })
            ->get();

        $doctors = $assignments->map(function ($assignment) {

            return [
                'assignment_id' => $assignment->id,
                'doctor_id' => $assignment->doctor->id,
                'user_id' => $assignment->doctor->user->id,
                'name' => $assignment->doctor->user->name,
                'expertise' => $assignment->doctor->expertise,
                'profession' => $assignment->doctor->profession,
                'experience' => $assignment->doctor->experience,
                'education' => $assignment->doctor->education,
            ];
        });

        return response()->json($doctors);
    }
    // Show selected doctor details
    public function show($assignmentId)
    {
        $assignment = DoctorAssignment::with([
            'doctor.user',
            'facilitySpecialization.facility.city',
            'facilitySpecialization.specialization',
        ])
        ->where('status', 'Active')
        ->whereHas('doctor', function ($query) {
            $query->where('status', 'Active');
        })
        ->whereHas('facilitySpecialization', function ($query) {
            $query->where('status', 'Active');
        })
        ->findOrFail($assignmentId);

        return view(
            'patient.PatientDoctorDetail',
            compact('assignment')
        );
    }
    // Get dates that still have available slots
    public function getAvailableDates($assignmentId)
    {
        $dates = DoctorAppointmentSlot::where(
                'doctor_assignment_id',
                $assignmentId
            )
            ->where('status', 'Available')
            ->whereDate('slot_date', '>=', today())
            ->select('slot_date')
            ->distinct()
            ->orderBy('slot_date')
            ->pluck('slot_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->values();

        return response()->json($dates);
    }
    // Get available slots for selected date
    public function getAvailableSlots(Request $request, $assignmentId)
    {
        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        $query = DoctorAppointmentSlot::where(
                'doctor_assignment_id',
                $assignmentId
            )
            ->whereDate('slot_date', $validated['date'])
            ->where('status', 'Available');

        // Nếu chọn chính ngày hôm nay,
        // không hiển thị giờ đã trôi qua
        if ($validated['date'] === today()->format('Y-m-d')) {
            $query->whereTime(
                'start_time',
                '>',
                now()->format('H:i:s')
            );
        }

        $slots = $query
            ->orderBy('start_time')
            ->get([
                'id',
                'slot_date',
                'start_time',
                'end_time',
            ])
            ->map(function ($slot) {

                return [
                    'id' => $slot->id,

                    'date' => Carbon::parse(
                        $slot->slot_date
                    )->format('Y-m-d'),

                    'start_time' => Carbon::parse(
                        $slot->start_time
                    )->format('H:i'),

                    'end_time' => Carbon::parse(
                        $slot->end_time
                    )->format('H:i'),
                ];
            });

        return response()->json($slots);
    }
}