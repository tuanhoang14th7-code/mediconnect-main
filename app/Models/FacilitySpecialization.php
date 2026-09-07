<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilitySpecialization extends Model
{
    protected $fillable = [
        'facility_id',
        'specialization_id',
        'status',
    ];

    public function facility()
    {
        return $this->belongsTo(
            Facility::class,
            'facility_id'
        );
    }

    public function specialization()
    {
        return $this->belongsTo(
            Specialization::class,
            'specialization_id'
        );
    }

    public function doctorAssignments()
    {
        return $this->hasMany(
            DoctorAssignment::class,
            'facility_specialization_id'
        );
    }
}