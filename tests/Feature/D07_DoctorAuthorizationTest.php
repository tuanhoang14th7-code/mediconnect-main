<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesAppointmentFixtures;
use Tests\TestCase;

/**
 * D07 - Fix Doctor authorization (IDOR on doctor profile endpoints).
 */
class D07_DoctorAuthorizationTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAppointmentFixtures;

    public function test_doctor_cannot_view_another_doctors_edit_form(): void
    {
        $owner = $this->makeDoctorUser();
        $this->makeDoctorProfile($owner);

        $attacker = $this->makeDoctorUser();
        $this->makeDoctorProfile($attacker, ['license_number' => 'ATTACKER-1']);

        $response = $this->actingAs($attacker)->get('Doctor/EditProfile/' . $owner->id);

        $response->assertForbidden();
    }

    public function test_doctor_can_view_their_own_edit_form(): void
    {
        $owner = $this->makeDoctorUser();
        $doctor = $this->makeDoctorProfile($owner);
        $assignment = $this->makeAssignment($doctor);
        \App\Models\DoctorSchedule::create([
            'doctor_assignment_id' => $assignment->id,
            'day' => 'Monday',
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'slot_duration_minutes' => 30,
        ]);

        $response = $this->actingAs($owner)->get('Doctor/EditProfile/' . $owner->id);

        $response->assertOk();
    }

    public function test_doctor_cannot_overwrite_another_doctors_profile_via_spoofed_ids(): void
    {
        $owner = $this->makeDoctorUser(['name' => 'Original Name']);
        $ownerDoctor = $this->makeDoctorProfile($owner);
        $this->makeAssignment($ownerDoctor);

        $attacker = $this->makeDoctorUser();
        $attackerDoctor = $this->makeDoctorProfile($attacker, ['license_number' => 'ATTACKER-1']);
        $this->makeAssignment($attackerDoctor);

        // Attacker tries to overwrite the owner's profile by spoofing user_id/id.
        $this->actingAs($attacker)->post('Doctor/SaveEditedInformationNow', [
            'user_id' => $owner->id,
            'id' => $ownerDoctor->id,
            'name' => 'Hacked Name',
            'email' => $owner->email,
            'number' => $owner->number,
            'expertise' => 'Hacked Expertise',
            'experience' => 1,
            'education' => 'Hacked',
            'profession' => 'Hacked',
            'days' => ['Monday'],
            'start_time' => '09:00',
            'end_time' => '10:00',
        ]);

        $this->assertSame('Original Name', $owner->fresh()->name);
        $this->assertNotSame('Hacked Expertise', $ownerDoctor->fresh()->expertise);
    }

    public function test_doctor_cannot_delete_another_doctors_account(): void
    {
        $owner = $this->makeDoctorUser();
        $this->makeDoctorProfile($owner);

        $attacker = $this->makeDoctorUser();
        $this->makeDoctorProfile($attacker, ['license_number' => 'ATTACKER-1']);

        $response = $this->actingAs($attacker)->get('Doctor/Delete/' . $owner->id);

        $response->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $owner->id]);
    }

    public function test_doctor_can_delete_their_own_account(): void
    {
        $owner = $this->makeDoctorUser();
        $this->makeDoctorProfile($owner);

        $response = $this->actingAs($owner)->get('Doctor/Delete/' . $owner->id);

        $response->assertRedirect('index');
        $this->assertDatabaseMissing('users', ['id' => $owner->id]);
    }

    public function test_doctor_cannot_update_another_doctors_appointment_status(): void
    {
        $owner = $this->makeDoctorUser();
        $ownerDoctor = $this->makeDoctorProfile($owner);
        $assignment = $this->makeAssignment($ownerDoctor);
        $slot = $this->makeSlot($assignment, ['status' => 'Booked']);
        $patient = $this->makePatientUser();

        $appointment = \App\Models\Appointments::create([
            'appointment_number' => 'APT-OWNER-0001',
            'patient_user_id' => $patient->id,
            'facility_specialization_id' => $assignment->facility_specialization_id,
            'doctor_assignment_id' => $assignment->id,
            'slot_id' => $slot->id,
            'patient_name' => $patient->name,
            'patient_phone' => $patient->number,
            'appointment_date' => $slot->slot_date,
            'start_time' => $slot->start_time,
            'end_time' => $slot->end_time,
            'status' => 'Confirmed',
            'booked_at' => now(),
        ]);

        $attacker = $this->makeDoctorUser();
        $this->makeDoctorProfile($attacker, ['license_number' => 'ATTACKER-1']);

        $response = $this->actingAs($attacker)->post('Doctor/Appointment/UpdateStatus', [
            'id' => $appointment->id,
            'status' => 'Completed',
        ]);

        $response->assertNotFound();
        $this->assertSame('Confirmed', $appointment->fresh()->status);
    }
}
