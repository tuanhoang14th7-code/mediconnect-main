<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function index(Request $req)
    {
        $query = City::withCount('facilities');

        if ($req->filled('keyword')) {
            $query->where('name', 'like', '%' . $req->keyword . '%');
        }

        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }

        $cities = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        return view('admin.cities.form', ['city' => new City(['country' => 'Vietnam', 'status' => 'Active'])]);
    }

    public function store(Request $req)
    {
        City::create($this->validated($req));

        return redirect('Admin/Cities')->with('success', 'City created successfully.');
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);

        return view('admin.cities.form', compact('city'));
    }

    public function update(Request $req, $id)
    {
        $city = City::findOrFail($id);
        $city->update($this->validated($req, $city->id));

        return redirect('Admin/Cities')->with('success', 'City updated successfully.');
    }

    /**
     * facilities.city_id uses ON DELETE RESTRICT, so a city that still has
     * facilities cannot be deleted. Mark it Inactive instead.
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);

        if ($city->facilities()->exists()) {
            return back()->with('error', 'Cannot delete: this city still has facilities. Set it to Inactive instead.');
        }

        $city->delete();

        return redirect('Admin/Cities')->with('success', 'City deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $city = City::findOrFail($id);
        $city->status = $city->status === 'Active' ? 'Inactive' : 'Active';
        $city->save();

        return back()->with('success', 'Status updated for city "' . $city->name . '".');
    }

    private function validated(Request $req, $ignoreId = null): array
    {
        return $req->validate([
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('cities')
                    ->where(fn($q) => $q->where('state', $req->state)->where('country', $req->country))
                    ->ignore($ignoreId),
            ],
            'state'   => ['nullable', 'string', 'max:120'],
            'country' => ['required', 'string', 'max:120'],
            'status'  => ['required', Rule::in(['Active', 'Inactive'])],
        ], [
            'name.required'    => 'City name is required.',
            'name.unique'      => 'This city already exists.',
            'country.required' => 'Country is required.',
        ]);
    }
}
