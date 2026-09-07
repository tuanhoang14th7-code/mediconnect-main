<?php

namespace Tests\Feature\Concerns;

use App\Models\City;
use App\Models\Doctor;
use App\Models\DoctorAppointmentSlot;
use App\Models\DoctorAssignment;
use App\Models\Facility;
use App\Models\FacilitySpecialization;
use App\Models\Specialization;
use App\Models\User;

/**
 * Shared fixtures for booking/appointment related feature tests.
 */
trait CreatesAppointmentFixtures
{
    private function makePatientUser(array $overrides = []): User
    {
        return User::factory()->create(array_merge(['user_type' => 'Patient'], $overrides));
    }

    private function makeDoctorUser(array $overrides = []): User
    {
        return User::factory()->create(array_merge(['user_type' => 'Doctor'], $overrides));
    }

    private function makeDoctorProfile(User $user, array $overrides = []): Doctor
    {
        return Doctor::create(array_merge([
            'image' => 'person1.jpg',
            'user_id' => $user->id,
            'expertise' => 'Dermatology',
            'experience' => 5,
            'education' => 'MBBS',
            'profession' => 'Skin Specialist',
            'status' => 'Active',
        ], $overrides));
    }

    private function makeAssignment(Doctor $doctor, array $overrides = []): DoctorAssignment
    {
        $city = City::create(['name' => 'City ' . uniqid(), 'country' => 'Vietnam', 'status' => 'Active']);

        $facility = Facility::create([
            'city_id' => $city->id,
            'name' => 'Facility ' . uniqid(),
            'code' => 'F' . uniqid(),
            'address' => 'Somewhere',
            'phone' => '0123456789',
            'status' => 'Active',
        ]);

        $specialization = Specialization::create([
            'name' => 'Specialization ' . uniqid(),
            'slug' => 'spec-' . uniqid(),
            'status' => 'Active',
        ]);

        $facilitySpecialization = FacilitySpecialization::create([
            'facility_id' => $facility->id,
            'specialization_id' => $specialization->id,
            'status' => 'Active',
        ]);

        return $doctor->assignments()->create(array_merge([
            'facility_specialization_id' => $facilitySpecialization->id,
            'status' => 'Active',
        ], $overrides));
    }

    private function makeSlot(DoctorAssignment $assignment, array $overrides = []): DoctorAppointmentSlot
    {
        return DoctorAppointmentSlot::create(array_merge([
            'doctor_assignment_id' => $assignment->id,
            'slot_date' => today()->addDay()->format('Y-m-d'),
            'start_time' => '09:00:00',
            'end_time' => '09:30:00',
            'status' => 'Available',
        ], $overrides));
    }
}
