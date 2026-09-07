<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\City;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{

    public function dashboard()
    {
        $total_doctor = User::where("user_type", 'Doctor')->count();
        $total_patient = User::where("user_type", 'Patient')->count();
        $total_apt = Appointments::count();

        // echo "<pre>";
        // echo $d;
        // echo "<br>";
        // echo $p;
        // echo "<br>";
        // echo $a;
        // die;

        return view('admin.AdminDashboard', compact('total_doctor', 'total_patient', 'total_apt'));
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

        // echo "<pre>";
        // print_r($appointments->toArray());
        // die;

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


    // ============= Patient Control =============

    public function patientList()
    {
        $patients = User::where('user_type', 'Patient')->paginate(8);
        return view('admin.AdminPatients', compact('patients'));
    }
    public function deleteThisPatient($id)
    {
        User::where('id', $id)->delete();
        return redirect('Admin/Patients');
    }

    // ============= Doctor Control =============

    public function registerDoctor(Request $req)
    {
        // echo "<pre>";
        // print_r($req->all());
        // die;
        $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|digits:10|regex:/^[0-9]{10}$/',
            'password' => 'required'
        ]);
        $data = User::create([
            'user_type' => $req->userType,
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password,
            'number' => $req->number
        ]);
        // echo $data['id'];
        // die;
        return redirect('Admin/AdminDoctorDetailsForm/' . $data['id'])->with('DoctorRegisterOKay', 'Doctor Register successfully');
    }

    public function doctorsList()
    {
        // $doctors = User::where('user_type', 'Doctor')->paginate(8);
        $doctors = User::with(['doctorDetails:id,user_id,status'])->where('user_type', 'Doctor')->paginate(8);
        // echo "<pre>";
        // echo $doctors[0]->doctorDetails->status;
        // print_r($doctors->toArray());
        // die;

        return view('admin.AdminDoctors', compact('doctors'));
    }

    public function getThisDoctorProfile($id)
    {
        $user = User::find($id);
        $doctor = Doctor::with('schedules')->where('user_id', $id)->first();
        // echo "<pre>";
        // print_r($doctor);
        // die;

        if ($doctor == null) {
            // echo 'NULL';
            return redirect('Admin/AdminDoctorDetailsForm/' . $id)->with('DoctorDetailsNotFound', 'This Doctor not submit it\'s Information!');
        } else {
            // echo 'Not Null';
            return view('admin.AdminDoctorProfile', compact('user', 'doctor'));
        }
    }

    public function updateDoctorStatus(Request $req)
    {
        $doctor = Doctor::find($req->id);
        // echo "<pre>";
        // print_r($req->all());
        // print_r($doctor->toArray());
        // echo $doctor->status;
        // die;

        if ($req->status == "Active") {
            $doctor->status = "Inactive";
        } else {
            $doctor->status = "Active";
        }
        $doctor->save();

        return redirect("Admin/Doctors")->with('statusUpdate', $req->name . 'Doctor Status Updated Successfully');
    }

    public function deleteThisDoctor($id)
    {
        User::where('id', $id)->delete();
        return redirect('Admin/Doctors')->with('DoctorDeletedDone', 'Doctor removed successfully');
    }

    public function getAddDoctorDetailsFormData($id)
    {
        $doctor = User::find($id);
        $cities = City::where('status', 'Active')->orderBy('name')->get();
        // echo "<pre>";
        // print_r($doctor->toArray());
        // die;
        return view('admin.AdminDoctorDetailsForm', compact('doctor', 'cities'));
    }

    public function saveDoctorDetails(Request $req)
    {
        // echo "<pre>";
        // print_r($req->all());
        // die;

        $req->validate([
            'image' => 'image',
            'expertise' => 'required',
            'experience' => 'required|numeric',
            'education' => 'required',
            'profession' => 'required',
            'days' => 'required|array|min:1',
            'city_id' => 'nullable|exists:cities,id',
            'slot_duration_minutes' => 'nullable|integer|min:5|max:480',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $file = $req->image;
        $name = time() . "." . $file->getClientOriginalExtension();
        $file->move(public_path('upload/doctors'), $name); // move file on upload folder

        User::where('id', $req->user_id)->update(['city_id' => $req->city_id]);

        $doctor = Doctor::create([
            'image' => $name,
            'user_id' => $req->user_id,
            'expertise' => $req->expertise,
            'experience' => $req->experience,
            'education' => $req->education,
            'profession' => $req->profession,
        ]);

        // Schema mới yêu cầu lịch làm việc gắn với doctor_assignment_id,
        // nên phải lấy (hoặc tự tạo) 1 assignment mặc định cho bác sĩ này
        try {
            $assignment = $doctor->firstOrCreateAssignment();
        } catch (\RuntimeException $e) {
            return redirect('Admin/DoctorProfile/' . $req->user_id)->with('doctorDetailsAddError', $e->getMessage());
        }

        foreach ($req->days as $day) {
            $schedule = DoctorSchedule::create([
                'doctor_assignment_id' => $assignment->id,
                'day' => $day,
                'start_time' => $req->start_time,
                'end_time' => $req->end_time,
                'slot_duration_minutes' => $req->slot_duration_minutes ?: 30,
                'valid_from' => $req->valid_from,
                'valid_until' => $req->valid_until,
            ]);
            $schedule->generateSlots();
        }

        return redirect('Admin/DoctorProfile/' . $req->user_id)->with('doctorDetailsAddOkay', 'Doctor Details add and save successfully');
    }

    public function getAdminEditDoctorDetailsFormData($id)
    {
        $user = User::find($id);
        $doctor = Doctor::with('schedules')->where('user_id', $id)->first();
        $cities = City::where('status', 'Active')->orderBy('name')->get();
        // echo "<pre>";
        // print_r($doctor->toArray());
        // die;
        $days[] = "";
        $i = 0;
        foreach ($doctor->schedules as $schedule) {
            $days[$i] = $schedule['day'];
            $i++;
        }
        return view('admin.AdminEditDoctorDetailsForm', compact('user', 'doctor', 'days', 'cities'));
    }

    public function saveThisDoctorDetails(Request $req)
    {
        $req->validate([
            'city_id' => 'nullable|exists:cities,id',
            'slot_duration_minutes' => 'nullable|integer|min:5|max:480',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'days' => 'required|array|min:1',
        ]);

        if ($req->hasFile('image')) {
            $file = $req->image;
            $name = time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('upload/doctors'), $name);
        }

        $user = User::find($req->user_id);

        $user->name = $req->name;
        $user->email = $req->email;
        $user->number = $req->number;
        $user->city_id = $req->city_id;

        $user->save();

        $doctor = Doctor::find($req->id);

        $doctor->expertise = $req->expertise;
        $doctor->experience = $req->experience;
        $doctor->education = $req->education;
        $doctor->profession = $req->profession;

        $doctor->save();

        // Xóa lịch cũ theo doctor_assignment_id (cột doctor_id không còn tồn tại)
        try {
            $assignment = $doctor->firstOrCreateAssignment();
        } catch (\RuntimeException $e) {
            return redirect('Admin/DoctorProfile/' . $req->user_id)->with('doctorDetailsAddError', $e->getMessage());
        }

        // Chỉ xóa các slot Available trong tương lai, giữ nguyên slot đã đặt
        $assignment->appointmentSlots()
            ->where('status', 'Available')
            ->whereDate('slot_date', '>=', today())
            ->delete();
        DoctorSchedule::where('doctor_assignment_id', $assignment->id)->delete();

        // echo "<pre>";
        // print_r($req->days);
        // die;
        foreach ($req->days as $day) {
            $schedule = DoctorSchedule::create([
                'doctor_assignment_id' => $assignment->id,
                'day' => $day,
                'start_time' => $req->start_time,
                'end_time' => $req->end_time,
                'slot_duration_minutes' => $req->slot_duration_minutes ?: 30,
                'valid_from' => $req->valid_from,
                'valid_until' => $req->valid_until,
            ]);
            $schedule->generateSlots();
        }
        return redirect('Admin/DoctorProfile/' . $req->user_id)->with('ThisDoctorEditedOkay', 'This Doctor Details Edited and Saves successfully');
    }
}
