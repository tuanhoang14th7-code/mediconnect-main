<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SpecializationController extends Controller
{
    public function index(Request $req)
    {
        $query = Specialization::withCount('facilitySpecializations');

        if ($req->filled('keyword')) {
            $query->where('name', 'like', '%' . $req->keyword . '%');
        }

        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }

        $specializations = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.specializations.index', compact('specializations'));
    }

    public function create()
    {
        return view('admin.specializations.form', [
            'specialization' => new Specialization(['status' => 'Active']),
        ]);
    }

    public function store(Request $req)
    {
        $data = $this->validated($req);
        $data['slug'] = $this->uniqueSlug($data['name']);

        Specialization::create($data);

        return redirect('Admin/Specializations')->with('success', 'Specialization created successfully.');
    }

    public function edit($id)
    {
        $specialization = Specialization::findOrFail($id);

        return view('admin.specializations.form', compact('specialization'));
    }

    public function update(Request $req, $id)
    {
        $specialization = Specialization::findOrFail($id);
        $data = $this->validated($req, $specialization->id);

        // Only regenerate the slug when the name changes
        if ($data['name'] !== $specialization->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $specialization->id);
        }

        $specialization->update($data);

        return redirect('Admin/Specializations')->with('success', 'Specialization updated successfully.');
    }

    /**
     * facility_specializations.specialization_id uses ON DELETE RESTRICT.
     */
    public function destroy($id)
    {
        $specialization = Specialization::findOrFail($id);

        if ($specialization->facilitySpecializations()->exists()) {
            return back()->with('error', 'Cannot delete: this specialization is still assigned to a facility. Set it to Inactive instead.');
        }

        $specialization->delete();

        return redirect('Admin/Specializations')->with('success', 'Specialization deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->status = $specialization->status === 'Active' ? 'Inactive' : 'Active';
        $specialization->save();

        return back()->with('success', 'Status updated for specialization "' . $specialization->name . '".');
    }

    private function validated(Request $req, $ignoreId = null): array
    {
        return $req->validate([
            'name'        => ['required', 'string', 'max:150', Rule::unique('specializations', 'name')->ignore($ignoreId)],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', Rule::in(['Active', 'Inactive'])],
        ], [
            'name.required' => 'Specialization name is required.',
            'name.unique'   => 'This specialization already exists.',
        ]);
    }

    private function uniqueSlug(string $name, $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'specialization';
        $slug = $base;
        $i = 2;

        while (
            Specialization::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
