<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    // Patient Dashboard
    public function dashboard()
    {
        $user = Auth::user();

        return view('patient.PatientDashboard', compact('user'));
    }


    // Appointment History
 
    // Show list of appointments of current patient
    public function myAppointments()
    {
        $appointments = Appointments::with([
            'doctorAssignment.doctor.user',
            'doctorAssignment.facilitySpecialization.facility',
            'doctorAssignment.facilitySpecialization.specialization',
        ])
        ->where('patient_user_id', Auth::id())
        ->orderByDesc('appointment_date')
        ->orderByDesc('start_time')
        ->get();

        return view(
            'patient.PatientMyAppointments',
            compact('appointments')
        );
    }
    // Show one (detail)appointment of current patient
    public function appointmentDetail($id)
    {
        $appointment = Appointments::with([
            'doctorAssignment.doctor.user',
            'doctorAssignment.facilitySpecialization.facility.city',
            'doctorAssignment.facilitySpecialization.specialization',
            'slot',
            'histories.changedBy',
        ])
        ->where('patient_user_id', Auth::id())
        ->findOrFail($id);

        return view(
            'patient.PatientAppointmentDetail',
            compact('appointment')
        );
    }


    // Show current patient's profile
    public function patientProfile()
    {
        $user = Auth::user();

        return view('patient.PatientProfile', compact('user'));
    }



    // Show edit profile form for current patient
    public function editPatientForm()
    {
        $user = Auth::user();

        return view(
            'patient.PatientEditProfile',
            compact('user')
        );
    }


    // Update current patient's profile
    public function editPatient(Request $req)
    {
        $user = Auth::user();

        $validated = $req->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'number')
                    ->ignore($user->id),
            ],

            'address' => [
                'required',
                'string',
                'max:500',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'gender' => [
                'nullable',
                'in:Male,Female,Other,Prefer not to say',
            ],

            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        // Upload new profile picture
        if ($req->hasFile('profile_picture')) {

            // Delete old profile picture
            if (
                $user->profile_picture &&
                Storage::disk('public')
                    ->exists($user->profile_picture)
            ) {
                Storage::disk('public')
                    ->delete($user->profile_picture);
            }

            // Store new profile picture
            $validated['profile_picture'] =
                $req->file('profile_picture')
                    ->store(
                        'profile_pictures',
                        'public'
                    );
        }


        $user->update($validated);


        return redirect('Patient/MyProfile')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }


    // Delete Patient Account
    public function deletePatient($id)
    {
        User::find($id)->delete();

        Auth::logout();

        return redirect('index');
    }

}