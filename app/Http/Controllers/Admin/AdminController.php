<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\City;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Accounts, split by the account_status the admin can toggle
        $accounts = [
            'doctors_total'    => User::where('user_type', 'Doctor')->count(),
            'doctors_active'   => User::where('user_type', 'Doctor')->where('account_status', 'Active')->count(),
            'patients_total'   => User::where('user_type', 'Patient')->count(),
            'patients_active'  => User::where('user_type', 'Patient')->where('account_status', 'Active')->count(),
            'doctors_no_profile' => User::where('user_type', 'Doctor')
                ->whereDoesntHave('doctorDetails')->count(),
        ];

        // One grouped query instead of six counts
        $byStatus = DB::table('appointments')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $appointments = [
            'total'     => (int) $byStatus->sum(),
            'pending'   => (int) ($byStatus['Pending'] ?? 0),
            'confirmed' => (int) ($byStatus['Confirmed'] ?? 0),
            'completed' => (int) ($byStatus['Completed'] ?? 0),
            'cancelled' => (int) ($byStatus['Cancelled'] ?? 0),
            'rejected'  => (int) ($byStatus['Rejected'] ?? 0),
            'no_show'   => (int) ($byStatus['NoShow'] ?? 0),
            'today'     => DB::table('appointments')->whereDate('appointment_date', now()->toDateString())->count(),
        ];

        // Master data the booking flow depends on; a zero here breaks patient search
        $masterData = [
            'cities'          => DB::table('cities')->where('status', 'Active')->count(),
            'facilities'      => DB::table('facilities')->where('status', 'Active')->count(),
            'specializations' => DB::table('specializations')->where('status', 'Active')->count(),
            'assignments'     => DB::table('doctor_assignments')->where('status', 'Active')->count(),
            'open_slots'      => DB::table('doctor_appointment_slots')->where('status', 'Available')->count(),
        ];

        $newContactMessages = DB::table('contact_messages')->where('status', 'New')->count();

        // Queue the admin actually has to act on
        $pendingQueue = DB::table('appointments')
            ->where('status', 'Pending')
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get(['appointment_number', 'patient_name', 'appointment_date', 'start_time']);

        return view('admin.AdminDashboard', compact(
            'accounts',
            'appointments',
            'masterData',
            'newContactMessages',
            'pendingQueue'
        ));
    }

    // ============= Appointment Control =============

    public function getAppointmentPage(Request $req)
    {
        $query = Appointments::with(['patient', 'doctorAssignment.doctor.user']);

        if ($req->filled('status')) {
            $query->where('status', $req->status);
        }

        if ($req->filled('search')) {
            $search = $req->search;
            $query->where(function ($q) use ($search) {
                $q->where('appointment_number', 'like', "%{$search}%")
                    ->orWhere('patient_name', 'like', "%{$search}%");
            });
        }

        $appointments = $query
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->paginate(8)
            ->withQueryString();

        return view('admin.AdminAppointments', compact('appointments'));
    }

    public function updateAppointmentStatus(Request $req)
    {
        $req->validate([
            'id' => 'required|integer',
            'status' => 'required|in:Pending,Confirmed,Rejected,Cancelled,Completed,NoShow',
        ]);

        $appointment = Appointments::findOrFail($req->id);

        $appointment->status = $req->status;
        $appointment->save();

        return redirect('Admin/Appointments');
    }

    // ============= Account Control =============

    /**
     * Accounts are never hard-deleted, they are deactivated.
     *
     * Deleting a user row cascades through doctors -> doctor_assignments ->
     * schedules and slots, and nulls the doctor and patient references on
     * appointments, appointment_histories, medical_contents and
     * contact_messages. For a clinic system that means losing the record of
     * who treated whom, so account_status is used instead: the account stays
     * intact and AuthController refuses the login.
     */
    public function toggleAccountStatus(Request $req, $id)
    {
        $user = User::findOrFail($id);

        // An admin must not be able to lock themselves out
        if ((int) $user->id === (int) auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->account_status = $user->account_status === 'Active' ? 'Inactive' : 'Active';
        $user->save();

        if ($user->account_status === 'Inactive') {
            // Drop any open session so the user is signed out immediately
            // (only has an effect when SESSION_DRIVER=database).
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        $state = $user->account_status === 'Active' ? 'reactivated' : 'deactivated';

        return back()->with('success', 'Account of ' . $user->name . ' has been ' . $state . '.');
    }

    // ============= Doctor Control =============

    public function showDoctorRegisterForm()
    {
        return view('admin.AdminDoctorRegister', [
            'cities' => City::where('status', 'Active')->orderBy('name')->get(),
        ]);
    }

    public function registerDoctor(Request $req)
    {
        $validated = $req->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'number'   => ['required', 'digits:10'],
            'password' => ['required', 'string', 'min:8'],
            'address'  => ['nullable', 'string', 'max:500'],
            'city_id'  => ['nullable', 'exists:cities,id'],
        ], [
            'name.required'     => 'Full name is required.',
            'email.unique'      => 'This email is already in use.',
            'number.digits'     => 'Phone number must be exactly 10 digits.',
            'password.min'      => 'Password must be at least 8 characters.',
        ]);

        // user_type is always Doctor on this screen; never read it from the request
        $data = User::create([
            'user_type'      => 'Doctor',
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'password'       => $validated['password'],
            'number'         => $validated['number'],
            'address'        => $validated['address'] ?? null,
            'city_id'        => $validated['city_id'] ?? null,
            'account_status' => 'Active',
        ]);

        return redirect('Admin/AdminDoctorDetailsForm/' . $data->id)
            ->with('DoctorRegisterOKay', 'Doctor account created. Please fill in the professional profile next.');
    }

    public function doctorsList(Request $req)
    {
        $query = User::with(['doctorDetails:id,user_id,status,expertise'])
            ->where('user_type', 'Doctor');

        if ($req->filled('keyword')) {
            $keyword = $req->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('number', 'like', '%' . $keyword . '%');
            });
        }

        if ($req->filled('account_status')) {
            $query->where('account_status', $req->account_status);
        }

        // Doctors whose professional profile is still missing
        if ($req->input('profile') === 'missing') {
            $query->whereDoesntHave('doctorDetails');
        } elseif ($req->filled('profile')) {
            $query->whereHas('doctorDetails', fn($q) => $q->where('status', $req->profile));
        }

        $doctors = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.AdminDoctors', compact('doctors'));
    }

    public function getThisDoctorProfile($id)
    {
        $user = User::find($id);

        // Eager load assignments (facility + specialization + room + fee)
        $doctor = Doctor::with([
            'assignments.facilitySpecialization.facility.city',
            'assignments.facilitySpecialization.specialization',
        ])->where('user_id', $id)->first();

        if ($doctor == null) {
            return redirect('Admin/AdminDoctorDetailsForm/' . $id)
                ->with('DoctorDetailsNotFound', 'This doctor has no professional profile yet.');
        }

        return view('admin.AdminDoctorProfile', compact('user', 'doctor'));
    }

    public function updateDoctorStatus(Request $req)
    {
        $doctor = Doctor::find($req->id);

        if (!$doctor) {
            return redirect('Admin/Doctors')->with('error', 'Doctor profile not found.');
        }

        $doctor->status = $doctor->status === 'Active' ? 'Inactive' : 'Active';
        $doctor->save();

        return redirect('Admin/Doctors')->with('success', 'Status updated for doctor ' . $req->name . '.');
    }

    public function getAddDoctorDetailsFormData($id)
    {
        $doctor = User::findOrFail($id);

        return view('admin.AdminDoctorDetailsForm', compact('doctor'));
    }

    /**
     * Creates only the professional profile (doctors table).
     * Workplace, fee and room live under Admin > Doctor Assignments.
     * Working schedules hang off doctor_assignment_id and belong to the Doctor module.
     */
    public function saveDoctorDetails(Request $req)
    {
        $validated = $req->validate([
            'user_id'        => ['required', 'exists:users,id'],
            'image'          => ['required', 'image', 'max:4096'],
            'expertise'      => ['required', 'string', 'max:255'],
            'experience'     => ['required', 'integer', 'min:0', 'max:80'],
            'education'      => ['required', 'string', 'max:255'],
            'profession'     => ['required', 'string', 'max:255'],
            'qualifications' => ['nullable', 'string', 'max:2000'],
            'license_number' => ['nullable', 'string', 'max:100', 'unique:doctors,license_number'],
            'bio'            => ['nullable', 'string', 'max:2000'],
            'status'         => ['required', Rule::in(['Active', 'Inactive'])],
        ], [
            'image.required'        => 'Please choose a profile photo.',
            'expertise.required'    => 'Expertise is required.',
            'experience.max'        => 'Years of experience is out of range.',
            'license_number.unique' => 'This license number already exists.',
        ]);

        if (Doctor::where('user_id', $validated['user_id'])->exists()) {
            return redirect('Admin/DoctorProfile/' . $validated['user_id'])
                ->with('error', 'This doctor already has a professional profile.');
        }

        $file = $req->file('image');
        $name = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/doctors'), $name);

        Doctor::create([
            'image'          => $name,
            'user_id'        => $validated['user_id'],
            'expertise'      => $validated['expertise'],
            'experience'     => $validated['experience'],
            'education'      => $validated['education'],
            'profession'     => $validated['profession'],
            'qualifications' => $validated['qualifications'] ?? null,
            'license_number' => $validated['license_number'] ?? null,
            'bio'            => $validated['bio'] ?? null,
            'status'         => $validated['status'],
        ]);

        return redirect('Admin/DoctorProfile/' . $validated['user_id'])
            ->with('doctorDetailsAddOkay', 'Professional profile saved. Next step: assign the doctor to a facility under Doctor Assignments.');
    }

    public function getAdminEditDoctorDetailsFormData($id)
    {
        $user   = User::findOrFail($id);
        $doctor = Doctor::where('user_id', $id)->first();

        if (!$doctor) {
            return redirect('Admin/AdminDoctorDetailsForm/' . $id)
                ->with('DoctorDetailsNotFound', 'This doctor has no professional profile yet.');
        }

        $cities = City::where('status', 'Active')->orderBy('name')->get();

        return view('admin.AdminEditDoctorDetailsForm', compact('user', 'doctor', 'cities'));
    }

    public function saveThisDoctorDetails(Request $req)
    {
        $doctor = Doctor::findOrFail($req->id);

        $validated = $req->validate([
            'user_id'        => ['required', 'exists:users,id'],
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($req->user_id)],
            'number'         => ['required', 'digits:10'],
            'address'        => ['nullable', 'string', 'max:500'],
            'city_id'        => ['nullable', 'exists:cities,id'],
            'image'          => ['nullable', 'image', 'max:4096'],
            'expertise'      => ['required', 'string', 'max:255'],
            'experience'     => ['required', 'integer', 'min:0', 'max:80'],
            'education'      => ['required', 'string', 'max:255'],
            'profession'     => ['required', 'string', 'max:255'],
            'qualifications' => ['nullable', 'string', 'max:2000'],
            'license_number' => ['nullable', 'string', 'max:100', Rule::unique('doctors', 'license_number')->ignore($doctor->id)],
            'bio'            => ['nullable', 'string', 'max:2000'],
            'status'         => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->name    = $validated['name'];
        $user->email   = $validated['email'];
        $user->number  = $validated['number'];
        $user->address = $validated['address'] ?? $user->address;
        $user->city_id = $validated['city_id'] ?? $user->city_id;
        $user->save();

        // Previous bug: the file was uploaded but the new filename was never stored
        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/doctors'), $name);
            $doctor->image = $name;
        }

        $doctor->expertise      = $validated['expertise'];
        $doctor->experience     = $validated['experience'];
        $doctor->education      = $validated['education'];
        $doctor->profession     = $validated['profession'];
        $doctor->qualifications = $validated['qualifications'] ?? null;
        $doctor->license_number = $validated['license_number'] ?? null;
        $doctor->bio            = $validated['bio'] ?? null;
        $doctor->status         = $validated['status'];
        $doctor->save();

        return redirect('Admin/DoctorProfile/' . $validated['user_id'])
            ->with('ThisDoctorEditedOkay', 'Doctor profile updated successfully.');
    }
}
