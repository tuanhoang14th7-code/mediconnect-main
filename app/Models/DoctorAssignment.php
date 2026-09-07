<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAssignment extends Model
{
    protected $fillable = [
        'doctor_id',
        'facility_specialization_id',
        'room_number',
        'consultation_fee',
        'status',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function facilitySpecialization()
    {
        return $this->belongsTo(
            FacilitySpecialization::class,
            'facility_specialization_id'
        );
    }

    public function appointmentSlots()
    {
        return $this->hasMany(
            DoctorAppointmentSlot::class,
            'doctor_assignment_id'
        );
    }
}