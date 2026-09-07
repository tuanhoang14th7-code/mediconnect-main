<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\City;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user(); // logged-in user 
        $doctor = Doctor::with(['schedules', 'appointment'])->where('user_id', $user->id)->first();
        // echo "<pre>";
        // echo $doctor->id;
        // print_r($doctor->appointment->toArray());
        // print_r($doctor->appointment[0]->day);
        // print_r($doctor->toArray());
        // die;

        if (!$doctor) {
            return redirect('Doctor/ShowDoctorDetailsForm');
        } else {
            return view('doctor.DoctorDashboard', compact('user', 'doctor'));
        }
    }

    public function updateAppointmentStatus(Request $req)
    {
        $req->validate([
            'id' => 'required|integer',
            'status' => 'required|in:Confirmed,Rejected,Cancelled,Completed,NoShow',
        ]);

        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        // Chỉ cho phép bác sĩ cập nhật appointment thuộc chính mình
        $appointment = Appointments::whereHas(
            'doctorAssignment',
            function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            }
        )->findOrFail($req->id);

        $appointment->status = $req->status;
        $appointment->save();
        return redirect('Doctor/DoctorDashboard');
    }

    public function doctorCollectDataForm()
    {
        $cities = City::where('status', 'Active')->orderBy('name')->get();
        return view('doctor.DoctorDetailsForm', compact('cities'));
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

        // Luôn dùng user đang đăng nhập, không tin user_id do client gửi lên
        User::where('id', Auth::id())->update(['city_id' => $req->city_id]);

        $doctor = Doctor::create([
            'image' => $name,
            'user_id' => Auth::id(),
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
            return redirect('Doctor/DoctorDashboard')->with('infoError', $e->getMessage());
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

        return redirect('Doctor/DoctorDashboard')->with('infoSave', 'Your information saved successfully');
    }

    public function getDoctorProfile()
    {
        $user = Auth::user();
        $doctor = Doctor::with('schedules')->where('user_id', $user->id)->first();
        // echo "<pre>";
        // print_r($doctor->toArray());
        // die;


        return view('doctor.DoctorProfile', compact('user', 'doctor'));
    }

    public function getEditDoctorForm($id)
    {
        // Chỉ cho phép bác sĩ xem/sửa đúng hồ sơ của chính mình
        abort_unless((int) $id === Auth::id(), 403);

        $user = User::find($id);
        $doctor = Doctor::with('schedules')->where('user_id', $id)->first();
        $cities = City::where('status', 'Active')->orderBy('name')->get();
        // echo "<pre>";
        // print_r($doctor->toArray());
        // print_r($doctor->schedules->toArray());
        $days[] = "";
        $i = 0;
        foreach ($doctor->schedules as $schedule) {
            $days[$i] = $schedule['day'];
            $i++;
        }
        // echo print_r($days);
        // die;
        return view('doctor.DoctorEditProfileForm', compact('user', 'doctor', 'days', 'cities'));
    }

    public function saveEditedDoctorDetails(Request $req)
    {
        // echo "<pre>";
        // print_r($req->all());
        // die;

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

        // Luôn thao tác trên hồ sơ của bác sĩ đang đăng nhập, bỏ qua user_id/id do client gửi lên
        $user = User::find(Auth::id());

        $user->name = $req->name;
        $user->email = $req->email;
        $user->number = $req->number;
        $user->city_id = $req->city_id;

        $user->save();

        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $doctor->expertise = $req->expertise;
        $doctor->experience = $req->experience;
        $doctor->education = $req->education;
        $doctor->profession = $req->profession;

        $doctor->save();

        // Xóa lịch cũ theo doctor_assignment_id (cột doctor_id không còn tồn tại)
        try {
            $assignment = $doctor->firstOrCreateAssignment();
        } catch (\RuntimeException $e) {
            return redirect('Doctor/DoctorDashboard')->with('infoError', $e->getMessage());
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

        return redirect('Doctor/DoctorDashboard')->with('infoSave', 'Your edited information saved successfully');
    }

    public function deleteDoctor($id)
    {
        // Chỉ cho phép bác sĩ xóa đúng tài khoản của chính mình
        abort_unless((int) $id === Auth::id(), 403);

        User::find($id)->delete();
        Auth::logout();
        return redirect('index')->with('doctorDeletedOkay', 'Your account and all data deleted permanently!');
    }
}
