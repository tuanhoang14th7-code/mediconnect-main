<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAppointmentSlot extends Model
{
    protected $fillable = [
        'doctor_assignment_id',
        'doctor_schedule_id',
        'slot_date',
        'start_time',
        'end_time',
        'status',
        'held_at',
        'booked_at',
        'blocked_reason',
    ];

    protected $casts = [
        'slot_date' => 'date',
        'held_at' => 'datetime',
        'booked_at' => 'datetime',
    ];

    public function doctorAssignment()
    {
        return $this->belongsTo(
            DoctorAssignment::class,
            'doctor_assignment_id'
        );
    }
}