<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentHistory extends Model
{
    protected $table = 'appointment_histories';

    const UPDATED_AT = null;

    protected $fillable = [
        'appointment_id',
        'changed_by_user_id',
        'action',
        'old_status',
        'new_status',
        'old_doctor_assignment_id',
        'new_doctor_assignment_id',
        'old_slot_id',
        'new_slot_id',
        'note',
    ];

    public function appointment()
    {
        return $this->belongsTo(
            Appointments::class,
            'appointment_id'
        );
    }

    public function changedBy()
    {
        return $this->belongsTo(
            User::class,
            'changed_by_user_id'
        );
    }
}