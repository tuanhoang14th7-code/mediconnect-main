<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Medical details of a patient, kept out of the users table.
 * One row per patient (patient_profiles.user_id is unique).
 */
class PatientProfile extends Model
{
    protected $table = 'patient_profiles';

    protected $fillable = [
        'user_id',
        'blood_group',
        'emergency_contact_name',
        'emergency_contact_number',
        'allergies',
        'medical_notes',
    ];

    public const BLOOD_GROUPS = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Unknown'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
