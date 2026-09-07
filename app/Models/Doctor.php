<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'image',
        'user_id',
        'expertise',
        'experience',
        'education',
        'qualifications',
        'profession',
        'license_number',
        'bio',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function assignments()
    {
        return $this->hasMany(
            DoctorAssignment::class,
            'doctor_id'
        );
    }

    public function schedules()
    {
        return $this->hasManyThrough(
            DoctorSchedule::class,
            DoctorAssignment::class,
            'doctor_id',
            'doctor_assignment_id',
            'id',
            'id'
        );
    }

    // Schema mới bắt buộc doctor_schedules phải gắn với 1 doctor_assignment
    // (không còn cột doctor_id), nhưng form nhập liệu cũ chưa thu thập
    // facility/specialization. Hàm này lấy assignment có sẵn hoặc tự tạo
    // một assignment mặc định để các form cũ vẫn lưu được lịch làm việc.
    public function firstOrCreateAssignment()
    {
        $assignment = $this->assignments()->first();

        if ($assignment) {
            return $assignment;
        }

        $facilitySpecialization = FacilitySpecialization::whereHas(
            'specialization',
            function ($query) {
                $query->where('name', $this->expertise);
            }
        )->where('status', 'Active')->first()
            ?? FacilitySpecialization::where('status', 'Active')->first();

        if (!$facilitySpecialization) {
            throw new \RuntimeException(
                'Cannot save working schedule: no active facility/specialization is configured yet. '
                . 'Please ask an administrator to set up at least one active facility and specialization first.'
            );
        }

        return $this->assignments()->create([
            'facility_specialization_id' => $facilitySpecialization->id,
            'status' => 'Active',
        ]);
    }

    public function appointment()
    {
        return $this->hasManyThrough(
            Appointments::class,
            DoctorAssignment::class,
            'doctor_id',
            'doctor_assignment_id',
            'id',
            'id'
        );
    }
}