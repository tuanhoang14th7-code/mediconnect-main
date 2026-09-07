<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Doctor;
use App\Models\Facility;
use App\Models\FacilitySpecialization;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * D01 - Add City to Doctor.
 */
class D01_AddCityToDoctorTest extends TestCase
{
    use RefreshDatabase;

    private function makeDoctorUser(): User
    {
        return User::factory()->create(['user_type' => 'Doctor']);
    }

    private function makeDoctorProfile(User $user): Doctor
    {
        return Doctor::create([
            'image' => 'person1.jpg',
            'user_id' => $user->id,
            'expertise' => 'Dermatology',
            'experience' => 5,
            'education' => 'MBBS',
            'profession' => 'Skin Specialist',
        ]);
    }

    /**
     * DoctorController::saveEditedDoctorDetails() always calls
     * Doctor::firstOrCreateAssignment(), which requires an Active
     * FacilitySpecialization to exist. Without seed data it crashes.
     */
    private function seedFacilitySpecialization(): void
    {
        $city = City::firstOrCreate(
            ['name' => 'Hanoi', 'state' => null, 'country' => 'Vietnam'],
            ['status' => 'Active']
        );
        $facility = Facility::create([
            'city_id' => $city->id,
            'name' => 'Test Facility ' . uniqid(),
            'code' => 'TF' . uniqid(),
            'address' => 'Somewhere',
            'phone' => '0123456789',
            'status' => 'Active',
        ]);
        $specialization = Specialization::firstOrCreate(
            ['slug' => 'dermatology'],
            ['name' => 'Dermatology', 'status' => 'Active']
        );
        FacilitySpecialization::create([
            'facility_id' => $facility->id,
            'specialization_id' => $specialization->id,
            'status' => 'Active',
        ]);
    }

    public function test_doctor_can_set_their_city_when_editing_profile(): void
    {
        $this->seedFacilitySpecialization();
        $city = City::create(['name' => 'Ho Chi Minh City', 'country' => 'Vietnam', 'status' => 'Active']);
        $user = $this->makeDoctorUser();
        $doctor = $this->makeDoctorProfile($user);

        $response = $this->actingAs($user)->post('Doctor/SaveEditedInformationNow', [
            'user_id' => $user->id,
            'id' => $doctor->id,
            'name' => $user->name,
            'email' => $user->email,
            'number' => $user->number,
            'city_id' => $city->id,
            'expertise' => 'Dermatology',
            'experience' => 5,
            'education' => 'MBBS',
            'profession' => 'Skin Specialist',
            'days' => ['Monday'],
            'start_time' => '09:00',
            'end_time' => '12:00',
        ]);

        $response->assertRedirect('Doctor/DoctorDashboard');
        $this->assertSame($city->id, $user->fresh()->city_id);
    }

    public function test_doctor_city_can_be_cleared_by_omitting_it(): void
    {
        $this->seedFacilitySpecialization();
        $city = City::create(['name' => 'Da Nang', 'country' => 'Vietnam', 'status' => 'Active']);
        $user = $this->makeDoctorUser();
        $user->update(['city_id' => $city->id]);
        $doctor = $this->makeDoctorProfile($user);

        $response = $this->actingAs($user)->post('Doctor/SaveEditedInformationNow', [
            'user_id' => $user->id,
            'id' => $doctor->id,
            'name' => $user->name,
            'email' => $user->email,
            'number' => $user->number,
            'expertise' => 'Dermatology',
            'experience' => 5,
            'education' => 'MBBS',
            'profession' => 'Skin Specialist',
            'days' => ['Monday'],
            'start_time' => '09:00',
            'end_time' => '12:00',
        ]);

        $response->assertRedirect('Doctor/DoctorDashboard');
        $this->assertNull($user->fresh()->city_id);
    }

    public function test_invalid_city_id_is_rejected_by_validation(): void
    {
        $this->seedFacilitySpecialization();
        $user = $this->makeDoctorUser();
        $doctor = $this->makeDoctorProfile($user);

        $response = $this->actingAs($user)->post('Doctor/SaveEditedInformationNow', [
            'user_id' => $user->id,
            'id' => $doctor->id,
            'name' => $user->name,
            'email' => $user->email,
            'number' => $user->number,
            'city_id' => 999999,
            'expertise' => 'Dermatology',
            'experience' => 5,
            'education' => 'MBBS',
            'profession' => 'Skin Specialist',
            'days' => ['Monday'],
            'start_time' => '09:00',
            'end_time' => '12:00',
        ]);

        $response->assertSessionHasErrors('city_id');
        $this->assertNull($user->fresh()->city_id);
    }

    public function test_saving_edited_profile_fails_gracefully_without_crashing_when_no_facility_specialization_exists(): void
    {
        $user = $this->makeDoctorUser();
        $doctor = $this->makeDoctorProfile($user);

        $response = $this->actingAs($user)->post('Doctor/SaveEditedInformationNow', [
            'user_id' => $user->id,
            'id' => $doctor->id,
            'name' => $user->name,
            'email' => $user->email,
            'number' => $user->number,
            'expertise' => 'Dermatology',
            'experience' => 5,
            'education' => 'MBBS',
            'profession' => 'Skin Specialist',
            'days' => ['Monday'],
            'start_time' => '09:00',
            'end_time' => '12:00',
        ]);

        $response->assertRedirect('Doctor/DoctorDashboard');
        $response->assertSessionHas('infoError');
    }

    public function test_edit_doctor_form_lists_active_cities_only(): void
    {
        $activeCity = City::create(['name' => 'Hanoi', 'country' => 'Vietnam', 'status' => 'Active']);
        $inactiveCity = City::create(['name' => 'Old Town', 'country' => 'Vietnam', 'status' => 'Inactive']);

        $user = $this->makeDoctorUser();
        $doctor = $this->makeDoctorProfile($user);

        $facility = Facility::create([
            'city_id' => $activeCity->id,
            'name' => 'Test Facility',
            'code' => 'TF1',
            'address' => 'Somewhere',
            'phone' => '0123456789',
            'status' => 'Active',
        ]);
        $specialization = Specialization::create([
            'name' => 'Dermatology',
            'slug' => 'dermatology',
            'status' => 'Active',
        ]);
        $facilitySpecialization = FacilitySpecialization::create([
            'facility_id' => $facility->id,
            'specialization_id' => $specialization->id,
            'status' => 'Active',
        ]);
        $assignment = $doctor->assignments()->create([
            'facility_specialization_id' => $facilitySpecialization->id,
            'status' => 'Active',
        ]);
        \App\Models\DoctorSchedule::create([
            'doctor_assignment_id' => $assignment->id,
            'day' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '12:00',
            'slot_duration_minutes' => 30,
        ]);

        $response = $this->actingAs($user)->get('Doctor/EditProfile/' . $user->id);

        $response->assertOk();
        $response->assertViewHas('cities', function ($cities) use ($activeCity, $inactiveCity) {
            return $cities->contains('id', $activeCity->id)
                && !$cities->contains('id', $inactiveCity->id);
        });
    }
}
