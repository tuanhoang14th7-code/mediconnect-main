<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilitySpecialization;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Manages which specializations each facility provides.
 * This pivot table drives the patient search flow:
 * City -> Facility -> Specialization -> Doctor.
 */
class FacilitySpecializationController extends Controller
{
    public function index(Request $req)
    {
        $query = FacilitySpecialization::with(['facility.city', 'specialization'])
            ->withCount('doctorAssignments');

        if ($req->filled('facility_id')) {
            $query->where('facility_id', $req->facility_id);
        }

        if ($req->filled('specialization_id')) {
            $query->where('specialization_id', $req->specialization_id);
        }

        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }

        $items = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('admin.facility-specializations.index', [
            'items'           => $items,
            'facilities'      => Facility::orderBy('name')->get(),
            'specializations' => Specialization::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.facility-specializations.form', [
            'item'            => new FacilitySpecialization(['status' => 'Active']),
            'facilities'      => Facility::where('status', 'Active')->orderBy('name')->get(),
            'specializations' => Specialization::where('status', 'Active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $req)
    {
        FacilitySpecialization::create($this->validated($req));

        return redirect('Admin/FacilitySpecializations')->with('success', 'Specialization assigned to the facility.');
    }

    public function edit($id)
    {
        return view('admin.facility-specializations.form', [
            'item'            => FacilitySpecialization::findOrFail($id),
            'facilities'      => Facility::orderBy('name')->get(),
            'specializations' => Specialization::orderBy('name')->get(),
        ]);
    }

    public function update(Request $req, $id)
    {
        $item = FacilitySpecialization::findOrFail($id);
        $item->update($this->validated($req, $item->id));

        return redirect('Admin/FacilitySpecializations')->with('success', 'Facility specialization updated.');
    }

    /**
     * doctor_assignments.facility_specialization_id uses ON DELETE RESTRICT.
     */
    public function destroy($id)
    {
        $item = FacilitySpecialization::findOrFail($id);

        if ($item->doctorAssignments()->exists()) {
            return back()->with('error', 'Cannot delete: doctors are still assigned to this specialization at this facility. Set it to Inactive instead.');
        }

        $item->delete();

        return redirect('Admin/FacilitySpecializations')->with('success', 'Specialization removed from the facility.');
    }

    public function toggleStatus($id)
    {
        $item = FacilitySpecialization::findOrFail($id);
        $item->status = $item->status === 'Active' ? 'Inactive' : 'Active';
        $item->save();

        return back()->with('success', 'Facility specialization status updated.');
    }

    private function validated(Request $req, $ignoreId = null): array
    {
        return $req->validate([
            'facility_id'       => ['required', 'exists:facilities,id'],
            'specialization_id' => [
                'required',
                'exists:specializations,id',
                Rule::unique('facility_specializations')
                    ->where(fn($q) => $q->where('facility_id', $req->facility_id))
                    ->ignore($ignoreId),
            ],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ], [
            'facility_id.required'         => 'Please select a facility.',
            'specialization_id.required'   => 'Please select a specialization.',
            'specialization_id.unique'     => 'This facility already has that specialization.',
        ]);
    }
}
