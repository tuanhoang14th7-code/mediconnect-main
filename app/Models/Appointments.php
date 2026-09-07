<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'appointment_number',
        'patient_user_id',
        'facility_specialization_id',
        'doctor_assignment_id',
        'slot_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'appointment_date',
        'start_time',
        'end_time',
        'examination_reason',
        'symptoms',
        'status',
        'rejection_reason',
        'cancellation_reason',
        'booked_at',
        'confirmed_at',
        'cancelled_at',
        'completed_at',
        'no_show_at',
        'reminder_created_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'booked_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
        'no_show_at' => 'datetime',
        'reminder_created_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(
            User::class,
            'patient_user_id'
        );
    }

    public function doctorAssignment()
    {
        return $this->belongsTo(
            DoctorAssignment::class,
            'doctor_assignment_id'
        );
    }

    public function facilitySpecialization()
    {
        return $this->belongsTo(
            FacilitySpecialization::class,
            'facility_specialization_id'
        );
    }

    public function slot()
    {
        return $this->belongsTo(
            DoctorAppointmentSlot::class,
            'slot_id'
        );
    }

    public function histories()
    {
        return $this->hasMany(
            AppointmentHistory::class,
            'appointment_id'
        );
    }
}