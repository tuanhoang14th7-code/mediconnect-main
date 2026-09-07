<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class LocalController extends Controller
{

    public function getDoctorsList()
    {
        $doctors = Doctor::with(['user'])->where('status', 'Active')->paginate(5);
        // echo "<pre>";
        // print_r($doctors->toArray());
        // die;

        return view('doctors', compact('doctors'));
    }

    public function getDoctorListForFilter(Request $req)
    {
        // echo "<pre>";
        // print_r($req->toArray());
        // die;
        $query = User::with(['doctorDetails'])->where('user_type', 'Doctor');

        if ($req->filled('expertise')) {
            $query->whereHas('doctorDetails', function ($q) use ($req) {
                $q->whereIn('expertise', $req->expertise);
            });
        }

        if ($req->filled('experience')) {
            $query->whereHas('doctorDetails', function ($q) use ($req) {
                $q->where(function ($sub) use ($req) {
                    foreach ($req->experience as $exp) {
                        if ($exp == "0-5") {
                            $sub->orWhere('experience', '<=', 5);
                        } elseif ($exp == "6-10") {
                            $sub->orWhereBetween('experience', [6, 10]);
                        } elseif ($exp == "11-15") {
                            $sub->orWhereBetween('experience', [11, 15]);
                        } elseif ($exp == "16+") {
                            $sub->orWhere('experience', '>=', 16);
                        }
                    }
                });
            });
        }

        if ($req->filled('profession')) {
            $query->whereHas('doctorDetails', function ($q) use ($req) {
                $q->whereIn('profession', $req->profession);
            });
        }

        // $users = $query->paginate(3);
        $users = $query->whereHas('doctorDetails', function ($q) {
            $q->whereIn('status', ["Active"]); // remove Inactive doctors
            // })->paginate(6);
        })->get();

        // echo "<pre>";
        // print_r($users->toArray());
        // die;

        $doctors = [];

        foreach ($users as $i => $u) {

            $details = $u->doctorDetails;

            // Không còn cột doctor_id trong doctor_schedules, dùng quan hệ
            // schedules() (đi qua doctor_assignments) đã khai báo trên Doctor
            $schedules = $details->schedules;
            // print_r($schedules->toArray());

            $days = [];
            $j = 0;
            foreach ($schedules as $s) {
                $days[$j] = $s['day'];
                $j++;
            }
            // print_r($days);
            // echo $schedules->first()->start_time;
            // echo "<br>";
            // echo $schedules->first()->end_time;
            // echo "<br><br>";

            if (!$details) continue;

            $doctors[$i]['id'] = $u->id;
            $doctors[$i]['doctor_id'] = $details->id;
            $doctors[$i]['name'] = $u->name;
            $doctors[$i]['image'] = $details->image;
            $doctors[$i]['expertise'] = $details->expertise;
            $doctors[$i]['experience'] = $details->experience;
            $doctors[$i]['education'] = $details->education;
            $doctors[$i]['profession'] = $details->profession;
            $doctors[$i]['days'] = $days;
            $doctors[$i]['start_time'] = $schedules->first()->start_time;
            $doctors[$i]['end_time'] = $schedules->first()->end_time;

            // print_r($doctors[$i]);
        }


        // echo "<pre>";
        // print_r($doctors);
        // die;
        return view('FilterDoctors', compact('doctors', 'users'));
        // return view('FilterDoctors', compact('doctors', 'users'));
    }


    public function getAppointmentForm(Request $req)
    {
        // echo "<pre>";
        // print_r($req->toArray());
        // echo $req->id;
        // die;

        if (!Auth::user()) {
            return redirect('login')->with("loginFail", "Please register or login for Appointment Booking!");
        }

        $user = User::find($req->id);
        $doctor = Doctor::with('schedules')->where('user_id', $req->id)->first();

        $days[] = "";
        $i = 0;
        foreach ($doctor->schedules as $schedule) {
            $days[$i] = $schedule['day'];
            $i++;
        }
        // echo "<pre>";
        // print_r($doctor->toArray());
        // echo $doctor->schedules[0]['start_time'];
        // die;
        return view('BookAppointment', compact('user', 'doctor', 'days'));
    }
    public function saveAppointment(Request $req)
    {
        // echo "<pre>";
        // print_r($req->toArray());
        // die;

        $data = Appointments::create([
            'user_id' => $req->userId,
            'doctor_id' => $req->doctorId,
            'name' => $req->name,
            'number' => $req->number,
            'day' => $req->day,
            'date' => $req->date,
            'time' => $req->time,
            'message' => $req->message
        ]);
        return redirect('Patient/PatientDashboard')->with('done', "Your appointment booked successfully!");
    }
    public function getThisDoctorDetails($id)
    {
        $user = User::find($id);
        $doctor = Doctor::with('schedules')->where('user_id', $id)->first();

        $days[] = "";
        $i = 0;
        foreach ($doctor->schedules as $schedule) {
            $days[$i] = $schedule['day'];
            $i++;
        }

        return view('doctor-details', compact('user', 'doctor', 'days'));
    }
}
