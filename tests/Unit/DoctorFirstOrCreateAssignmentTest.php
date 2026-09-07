<?php

namespace Tests\Unit;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorFirstOrCreateAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_throws_clear_error_when_no_active_facility_specialization_exists(): void
    {
        $user = User::factory()->create(['user_type' => 'Doctor']);
        $doctor = Doctor::create([
            'image' => 'person1.jpg',
            'user_id' => $user->id,
            'expertise' => 'Dermatology',
            'experience' => 5,
            'education' => 'MBBS',
            'profession' => 'Skin Specialist',
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('no active facility/specialization is configured yet');

        $doctor->firstOrCreateAssignment();
    }
}
