<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Facility;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Smoke tests for the Admin/* master-data controllers brought in from the
 * old project (cities, facilities, specializations, facility-specializations,
 * doctor assignments, patients) to catch obvious wiring/view mistakes.
 */
class AdminMasterDataSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create(['user_type' => 'Admin']);
    }

    public function test_admin_can_view_and_create_a_city(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->get('Admin/Cities')->assertOk();
        $this->actingAs($admin)->get('Admin/Cities/Create')->assertOk();

        $response = $this->actingAs($admin)->post('Admin/Cities/Store', [
            'name' => 'Hue',
            'country' => 'Vietnam',
            'status' => 'Active',
        ]);

        $response->assertRedirect('Admin/Cities');
        $this->assertDatabaseHas('cities', ['name' => 'Hue']);
    }

    public function test_admin_can_view_and_create_a_facility(): void
    {
        $admin = $this->makeAdmin();
        $city = City::create(['name' => 'Hanoi', 'country' => 'Vietnam', 'status' => 'Active']);

        $this->actingAs($admin)->get('Admin/Facilities')->assertOk();

        $response = $this->actingAs($admin)->post('Admin/Facilities/Store', [
            'city_id' => $city->id,
            'name' => 'Test Hospital',
            'code' => 'TH1',
            'address' => 'Somewhere',
            'phone' => '0123456789',
            'status' => 'Active',
        ]);

        $response->assertRedirect('Admin/Facilities');
        $this->assertDatabaseHas('facilities', ['code' => 'TH1']);
    }

    public function test_admin_can_view_and_create_a_specialization(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->get('Admin/Specializations')->assertOk();

        $response = $this->actingAs($admin)->post('Admin/Specializations/Store', [
            'name' => 'Test Specialization',
            'status' => 'Active',
        ]);

        $response->assertRedirect('Admin/Specializations');
        $this->assertDatabaseHas('specializations', ['name' => 'Test Specialization']);
    }

    public function test_admin_can_view_facility_specializations_and_doctor_assignments_pages(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->get('Admin/FacilitySpecializations')->assertOk();
        $this->actingAs($admin)->get('Admin/DoctorAssignments')->assertOk();
    }

    public function test_admin_can_create_a_patient_account_with_profile(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post('Admin/Patients/Store', [
            'name' => 'New Patient',
            'email' => 'new.patient@example.com',
            'number' => '0987654321',
            'address' => '123 Somewhere',
            'password' => 'password123',
            'account_status' => 'Active',
            'blood_group' => 'O+',
        ]);

        $response->assertRedirect('Admin/Patients');
        $this->assertDatabaseHas('users', ['email' => 'new.patient@example.com', 'user_type' => 'Patient']);
        $this->assertDatabaseHas('patient_profiles', ['blood_group' => 'O+']);
    }

    public function test_admin_can_toggle_a_users_account_status(): void
    {
        $admin = $this->makeAdmin();
        $patient = User::factory()->create(['user_type' => 'Patient', 'account_status' => 'Active']);

        $response = $this->actingAs($admin)->post('Admin/User/ToggleAccountStatus/' . $patient->id);

        $response->assertRedirect();
        $this->assertSame('Inactive', $patient->fresh()->account_status);
    }

    public function test_admin_cannot_deactivate_their_own_account(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post('Admin/User/ToggleAccountStatus/' . $admin->id);

        $response->assertRedirect();
        $this->assertSame('Active', $admin->fresh()->account_status);
    }

    public function test_deactivated_admin_is_logged_out_by_middleware(): void
    {
        $admin = $this->makeAdmin();
        $admin->update(['account_status' => 'Inactive']);

        $response = $this->actingAs($admin)->get('Admin/AdminDashboard');

        $response->assertRedirect('login');
    }
}
