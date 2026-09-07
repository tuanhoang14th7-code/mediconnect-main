<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FacilityController extends Controller
{
    public function index(Request $req)
    {
        $query = Facility::with('city')->withCount('facilitySpecializations');

        if ($req->filled('keyword')) {
            $query->where(function ($q) use ($req) {
                $q->where('name', 'like', '%' . $req->keyword . '%')
                    ->orWhere('code', 'like', '%' . $req->keyword . '%');
            });
        }

        if ($req->filled('city_id')) {
            $query->where('city_id', $req->city_id);
        }

        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }

        $facilities = $query->orderBy('name')->paginate(10)->withQueryString();
        $cities = City::orderBy('name')->get();

        return view('admin.facilities.index', compact('facilities', 'cities'));
    }

    public function create()
    {
        return view('admin.facilities.form', [
            'facility' => new Facility(['status' => 'Active']),
            'cities'   => City::where('status', 'Active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $req)
    {
        Facility::create($this->validated($req));

        return redirect('Admin/Facilities')->with('success', 'Facility created successfully.');
    }

    public function edit($id)
    {
        return view('admin.facilities.form', [
            'facility' => Facility::findOrFail($id),
            'cities'   => City::orderBy('name')->get(),
        ]);
    }

    public function update(Request $req, $id)
    {
        $facility = Facility::findOrFail($id);
        $facility->update($this->validated($req, $facility->id));

        return redirect('Admin/Facilities')->with('success', 'Facility updated successfully.');
    }

    /**
     * facility_specializations cascade when a facility is deleted, but
     * doctor_assignments.facility_specialization_id is RESTRICT,
     * so block deletion while doctors are still assigned here.
     */
    public function destroy($id)
    {
        $facility = Facility::withCount('facilitySpecializations')->findOrFail($id);

        $hasAssignment = $facility->facilitySpecializations()
            ->whereHas('doctorAssignments')
            ->exists();

        if ($hasAssignment) {
            return back()->with('error', 'Cannot delete: doctors are still assigned to this facility. Set it to Inactive instead.');
        }

        $facility->delete();

        return redirect('Admin/Facilities')->with('success', 'Facility deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->status = $facility->status === 'Active' ? 'Inactive' : 'Active';
        $facility->save();

        return back()->with('success', 'Status updated for facility "' . $facility->name . '".');
    }

    private function validated(Request $req, $ignoreId = null): array
    {
        return $req->validate([
            'city_id' => ['required', 'exists:cities,id'],
            'name'    => [
                'required',
                'string',
                'max:255',
                Rule::unique('facilities')->where(fn($q) => $q->where('city_id', $req->city_id))->ignore($ignoreId),
            ],
            'code'        => ['required', 'string', 'max:30', Rule::unique('facilities', 'code')->ignore($ignoreId)],
            'address'     => ['required', 'string', 'max:500'],
            'phone'       => ['required', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', Rule::in(['Active', 'Inactive'])],
        ], [
            'city_id.required' => 'Please select a city.',
            'name.required'    => 'Facility name is required.',
            'name.unique'      => 'This city already has a facility with the same name.',
            'code.required'    => 'Facility code is required.',
            'code.unique'      => 'This facility code is already in use.',
            'address.required' => 'Address is required.',
            'phone.required'   => 'Phone number is required.',
        ]);
    }
}
