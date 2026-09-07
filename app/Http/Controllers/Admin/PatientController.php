<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Patient accounts and their medical profile.
 *
 * Note: users has a CHECK constraint (user_type <> 'Patient' OR address IS NOT NULL),
 * so address is mandatory for every patient. Accounts are never deleted here,
 * only deactivated through AdminController::toggleAccountStatus.
 */
class PatientController extends Controller
{
    public function index(Request $req)
    {
        $query = User::where('user_type', 'Patient');

        if ($req->filled('keyword')) {
            $keyword = $req->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('number', 'like', '%' . $keyword . '%');
            });
        }

        if ($req->filled('city_id')) {
            $query->where('city_id', $req->city_id);
        }

        if ($req->filled('account_status')) {
            $query->where('account_status', $req->account_status);
        }

        $patients = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.AdminPatients', [
            'patients'  => $patients,
            'cities'    => City::orderBy('name')->get(),
            // User has no city() relation yet (shared model), so names are resolved here
            'cityNames' => City::pluck('name', 'id'),
        ]);
    }

    public function show($id)
    {
        $patient = User::where('user_type', 'Patient')->findOrFail($id);
        $cityName = $patient->city_id ? City::whereKey($patient->city_id)->value('name') : null;

        $profile = PatientProfile::where('user_id', $patient->id)->first();

        $appointments = DB::table('appointments')
            ->where('patient_user_id', $patient->id)
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->limit(20)
            ->get(['appointment_number', 'appointment_date', 'start_time', 'end_time', 'status']);

        return view('admin.patients.show', compact('patient', 'profile', 'appointments', 'cityName'));
    }

    public function create()
    {
        return view('admin.patients.form', [
            'patient' => new User(['account_status' => 'Active']),
            'profile' => new PatientProfile(['blood_group' => 'Unknown']),
            'cities'  => City::where('status', 'Active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $req)
    {
        $data = $this->validated($req);

        DB::transaction(function () use ($data) {
            $patient = User::create([
                'user_type'      => 'Patient',
                'name'           => $data['name'],
                'email'          => $data['email'],
                'number'         => $data['number'],
                'address'        => $data['address'],
                'city_id'        => $data['city_id'] ?? null,
                'date_of_birth'  => $data['date_of_birth'] ?? null,
                'gender'         => $data['gender'] ?? null,
                'password'       => $data['password'],
                'account_status' => $data['account_status'],
            ]);

            $this->saveProfile($patient->id, $data);
        });

        return redirect('Admin/Patients')->with('success', 'Patient account created successfully.');
    }

    public function edit($id)
    {
        $patient = User::where('user_type', 'Patient')->findOrFail($id);

        return view('admin.patients.form', [
            'patient' => $patient,
            'profile' => PatientProfile::where('user_id', $patient->id)->first() ?? new PatientProfile(['blood_group' => 'Unknown']),
            'cities'  => City::orderBy('name')->get(),
        ]);
    }

    public function update(Request $req, $id)
    {
        $patient = User::where('user_type', 'Patient')->findOrFail($id);
        $data    = $this->validated($req, $patient->id);

        DB::transaction(function () use ($patient, $data) {
            $patient->name           = $data['name'];
            $patient->email          = $data['email'];
            $patient->number         = $data['number'];
            $patient->address        = $data['address'];
            $patient->city_id        = $data['city_id'] ?? null;
            $patient->date_of_birth  = $data['date_of_birth'] ?? null;
            $patient->gender         = $data['gender'] ?? null;
            $patient->account_status = $data['account_status'];

            // Password is optional on edit; the hashed cast handles the encoding
            if (!empty($data['password'])) {
                $patient->password = $data['password'];
            }

            $patient->save();

            $this->saveProfile($patient->id, $data);
        });

        return redirect('Admin/Patients/Show/' . $patient->id)->with('success', 'Patient updated successfully.');
    }

    private function saveProfile(int $userId, array $data): void
    {
        PatientProfile::updateOrCreate(
            ['user_id' => $userId],
            [
                'blood_group'              => $data['blood_group'] ?? 'Unknown',
                'emergency_contact_name'   => $data['emergency_contact_name'] ?? null,
                'emergency_contact_number' => $data['emergency_contact_number'] ?? null,
                'allergies'                => $data['allergies'] ?? null,
                'medical_notes'            => $data['medical_notes'] ?? null,
            ]
        );
    }

    private function validated(Request $req, $ignoreId = null): array
    {
        return $req->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($ignoreId)],
            'number'  => ['required', 'digits:10', Rule::unique('users', 'number')->ignore($ignoreId)],
            // Required by the users_patient_address_check constraint
            'address' => ['required', 'string', 'max:500'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender'  => ['nullable', Rule::in(['Male', 'Female', 'Other', 'Prefer not to say'])],
            'password' => [$ignoreId ? 'nullable' : 'required', 'string', 'min:8'],
            'account_status' => ['required', Rule::in(['Active', 'Inactive'])],

            'blood_group'              => ['nullable', Rule::in(PatientProfile::BLOOD_GROUPS)],
            'emergency_contact_name'   => ['nullable', 'string', 'max:255'],
            'emergency_contact_number' => ['nullable', 'string', 'max:20'],
            'allergies'                => ['nullable', 'string', 'max:2000'],
            'medical_notes'            => ['nullable', 'string', 'max:2000'],
        ], [
            'name.required'     => 'Full name is required.',
            'email.unique'      => 'This email is already in use.',
            'number.digits'     => 'Phone number must be exactly 10 digits.',
            'number.unique'     => 'This phone number is already in use.',
            'address.required'  => 'Address is required for a patient account.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 8 characters.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
        ]);
    }
}
