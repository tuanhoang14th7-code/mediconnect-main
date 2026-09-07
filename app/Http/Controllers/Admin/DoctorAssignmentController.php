<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorAssignment;
use App\Models\Facility;
use App\Models\FacilitySpecialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Assigns a doctor to a (facility + specialization) pair.
 *
 * This is the key link in the booking flow:
 *   City -> Facility -> Specialization -> DoctorAssignment -> Schedule -> Slot -> Appointment
 *
 * Consultation fee and room number belong to the assignment, not to the doctors
 * table, because one doctor may work at several facilities with different fees.
 */
class DoctorAssignmentController extends Controller
{
    public function index(Request $req)
    {
        $query = DoctorAssignment::with([
            'doctor.user',
            'facilitySpecialization.facility.city',
            'facilitySpecialization.specialization',
        ])->withCount('appointmentSlots');

        if ($req->filled('keyword')) {
            $keyword = $req->keyword;
            $query->whereHas('doctor.user', function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        if ($req->filled('facility_id')) {
            $query->whereHas('facilitySpecialization', fn($q) => $q->where('facility_id', $req->facility_id));
        }

        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }

        $assignments = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('admin.doctor-assignments.index', [
            'assignments' => $assignments,
            'facilities'  => Facility::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.doctor-assignments.form', [
            'assignment'              => new DoctorAssignment(['status' => 'Active', 'consultation_fee' => 0]),
            'doctors'                 => $this->doctorOptions(),
            'facilitySpecializations' => $this->facilitySpecializationOptions(),
        ]);
    }

    public function store(Request $req)
    {
        DoctorAssignment::create($this->validated($req));

        return redirect('Admin/DoctorAssignments')->with('success', 'Doctor assigned to the facility successfully.');
    }

    public function edit($id)
    {
        return view('admin.doctor-assignments.form', [
            'assignment'              => DoctorAssignment::findOrFail($id),
            'doctors'                 => $this->doctorOptions(),
            'facilitySpecializations' => $this->facilitySpecializationOptions(),
        ]);
    }

    public function update(Request $req, $id)
    {
        $assignment = DoctorAssignment::findOrFail($id);
        $assignment->update($this->validated($req, $assignment->id));

        return redirect('Admin/DoctorAssignments')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Deleting an assignment cascades to its schedules and generated slots,
     * so it is only allowed when no slot is held/booked and no appointment is live.
     */
    public function destroy($id)
    {
        $assignment = DoctorAssignment::findOrFail($id);

        $hasLiveSlot = $assignment->appointmentSlots()
            ->whereIn('status', ['Held', 'Booked'])
            ->exists();

        if ($hasLiveSlot) {
            return back()->with('error', 'Cannot delete: some slots are currently held or booked. Set the assignment to Inactive instead.');
        }

        $hasLiveAppointment = DB::table('appointments')
            ->where('doctor_assignment_id', $assignment->id)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->exists();

        if ($hasLiveAppointment) {
            return back()->with('error', 'Cannot delete: there are pending or confirmed appointments. Set the assignment to Inactive instead.');
        }

        $assignment->delete();

        return redirect('Admin/DoctorAssignments')->with('success', 'Assignment deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $assignment = DoctorAssignment::findOrFail($id);
        $assignment->status = $assignment->status === 'Active' ? 'Inactive' : 'Active';
        $assignment->save();

        return back()->with('success', 'Assignment status updated.');
    }

    private function validated(Request $req, $ignoreId = null): array
    {
        return $req->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'facility_specialization_id' => [
                'required',
                'exists:facility_specializations,id',
                Rule::unique('doctor_assignments')
                    ->where(fn($q) => $q->where('doctor_id', $req->doctor_id))
                    ->ignore($ignoreId),
            ],
            'room_number'      => ['nullable', 'string', 'max:50'],
            'consultation_fee' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'status'           => ['required', Rule::in(['Active', 'Inactive'])],
        ], [
            'doctor_id.required'                  => 'Please select a doctor.',
            'facility_specialization_id.required' => 'Please select a facility and specialization.',
            'facility_specialization_id.unique'   => 'This doctor is already assigned to that facility and specialization.',
            'consultation_fee.required'           => 'Please enter the consultation fee.',
            'consultation_fee.min'                => 'Consultation fee cannot be negative.',
        ]);
    }

    /** Active doctors with their account name, for the dropdown. */
    private function doctorOptions()
    {
        return Doctor::with('user:id,name,email')
            ->where('status', 'Active')
            ->get()
            ->sortBy(fn($d) => $d->user->name ?? '');
    }

    /** Active facility/specialization pairs, sorted for readable grouping. */
    private function facilitySpecializationOptions()
    {
        return FacilitySpecialization::with(['facility.city', 'specialization'])
            ->where('status', 'Active')
            ->get()
            ->sortBy(fn($fs) => ($fs->facility->name ?? '') . ' ' . ($fs->specialization->name ?? ''));
    }
}
