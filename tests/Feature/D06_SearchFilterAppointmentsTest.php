<?php

namespace Tests\Feature;

use App\Models\Appointments;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesAppointmentFixtures;
use Tests\TestCase;

/**
 * D06 - Search/filter appointments.
 */
class D06_SearchFilterAppointmentsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAppointmentFixtures;

    private function makeAppointment($patient, $assignment, $slot, array $overrides = []): Appointments
    {
        return Appointments::create(array_merge([
            'appointment_number' => 'APT-' . uniqid(),
            'patient_user_id' => $patient->id,
            'facility_specialization_id' => $assignment->facility_specialization_id,
            'doctor_assignment_id' => $assignment->id,
            'slot_id' => $slot->id,
            'patient_name' => $patient->name,
            'patient_phone' => $patient->number,
            'appointment_date' => $slot->slot_date,
            'start_time' => $slot->start_time,
            'end_time' => $slot->end_time,
            'status' => 'Pending',
            'booked_at' => now(),
        ], $overrides));
    }

    public function test_admin_can_view_appointments_list_without_crashing(): void
    {
        $admin = User::factory()->create(['user_type' => 'Admin']);
        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $slot = $this->makeSlot($assignment);
        $this->makeAppointment($patient, $assignment, $slot);

        $response = $this->actingAs($admin)->get('Admin/Appointments');

        $response->assertOk();
        $response->assertViewHas('appointments');
    }

    public function test_admin_can_filter_appointments_by_status(): void
    {
        $admin = User::factory()->create(['user_type' => 'Admin']);
        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);

        $pendingSlot = $this->makeSlot($assignment, ['start_time' => '09:00:00', 'end_time' => '09:30:00']);
        $pending = $this->makeAppointment($patient, $assignment, $pendingSlot, ['status' => 'Pending']);

        $completedSlot = $this->makeSlot($assignment, ['start_time' => '10:00:00', 'end_time' => '10:30:00']);
        $completed = $this->makeAppointment($patient, $assignment, $completedSlot, ['status' => 'Completed']);

        $response = $this->actingAs($admin)->get('Admin/Appointments?status=Completed');

        $response->assertOk();
        $appointments = $response->viewData('appointments');
        $this->assertTrue($appointments->contains('id', $completed->id));
        $this->assertFalse($appointments->contains('id', $pending->id));
    }

    public function test_admin_can_search_appointments_by_appointment_number(): void
    {
        $admin = User::factory()->create(['user_type' => 'Admin']);
        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);

        $slotOne = $this->makeSlot($assignment, ['start_time' => '09:00:00', 'end_time' => '09:30:00']);
        $target = $this->makeAppointment($patient, $assignment, $slotOne, ['appointment_number' => 'APT-2026-FIND-ME']);

        $slotTwo = $this->makeSlot($assignment, ['start_time' => '10:00:00', 'end_time' => '10:30:00']);
        $other = $this->makeAppointment($patient, $assignment, $slotTwo, ['appointment_number' => 'APT-2026-OTHER']);

        $response = $this->actingAs($admin)->get('Admin/Appointments?search=FIND-ME');

        $response->assertOk();
        $appointments = $response->viewData('appointments');
        $this->assertTrue($appointments->contains('id', $target->id));
        $this->assertFalse($appointments->contains('id', $other->id));
    }

    public function test_admin_appointment_status_update_rejects_invalid_status(): void
    {
        $admin = User::factory()->create(['user_type' => 'Admin']);
        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $slot = $this->makeSlot($assignment);
        $appointment = $this->makeAppointment($patient, $assignment, $slot);

        $response = $this->actingAs($admin)->post('Admin/Appointment/UpdateStatus', [
            'id' => $appointment->id,
            'status' => 'NotARealStatus',
        ]);

        $response->assertSessionHasErrors('status');
        $this->assertSame('Pending', $appointment->fresh()->status);
    }
}
