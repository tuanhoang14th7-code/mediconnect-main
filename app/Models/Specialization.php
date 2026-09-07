<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    public function facilitySpecializations()
    {
        return $this->hasMany(
            FacilitySpecialization::class,
            'specialization_id'
        );
    }
}