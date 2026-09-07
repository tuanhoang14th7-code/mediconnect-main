<?php

namespace Tests\Feature;

use App\Models\Appointments;
use App\Notifications\AppointmentCancelledNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\Feature\Concerns\CreatesAppointmentFixtures;
use Tests\TestCase;

/**
 * D05 - Cancellation Notification.
 */
class D05_CancellationNotificationTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAppointmentFixtures;

    private function makeAppointment($patient, $assignment, $slot, string $number = 'APT-TEST-0001'): Appointments
    {
        return Appointments::create([
            'appointment_number' => $number,
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
        ]);
    }

    public function test_patient_receives_notification_when_cancelling_an_appointment(): void
    {
        Notification::fake();

        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $slot = $this->makeSlot($assignment, ['status' => 'Booked']);
        $appointment = $this->makeAppointment($patient, $assignment, $slot);

        $response = $this->actingAs($patient)->post(
            "/Patient/Appointments/{$appointment->id}/Cancel",
            ['cancellation_reason' => 'Change of plans']
        );

        $response->assertRedirect(route('patient.appointments.show', $appointment->id));

        Notification::assertSentTo($patient, AppointmentCancelledNotification::class);

        $appointment->refresh();
        $this->assertSame('Cancelled', $appointment->status);
        $this->assertSame('Change of plans', $appointment->cancellation_reason);
        $this->assertSame('Available', $slot->fresh()->status);
        $this->assertDatabaseHas('appointment_histories', [
            'appointment_id' => $appointment->id,
            'action' => 'Cancelled',
        ]);
    }

    public function test_completed_appointment_cannot_be_cancelled(): void
    {
        Notification::fake();

        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $slot = $this->makeSlot($assignment, ['status' => 'Booked']);
        $appointment = $this->makeAppointment($patient, $assignment, $slot);
        $appointment->update(['status' => 'Completed']);

        $response = $this->actingAs($patient)->post(
            "/Patient/Appointments/{$appointment->id}/Cancel",
            ['cancellation_reason' => 'Change of plans']
        );

        $response->assertSessionHasErrors('cancellation_reason');
        Notification::assertNothingSent();
        $this->assertSame('Completed', $appointment->fresh()->status);
    }

    public function test_patient_cannot_cancel_another_patients_appointment(): void
    {
        Notification::fake();

        $patient = $this->makePatientUser();
        $otherPatient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $slot = $this->makeSlot($assignment, ['status' => 'Booked']);
        $appointment = $this->makeAppointment($patient, $assignment, $slot);

        $response = $this->actingAs($otherPatient)->post(
            "/Patient/Appointments/{$appointment->id}/Cancel",
            ['cancellation_reason' => 'Not mine']
        );

        $response->assertNotFound();
        Notification::assertNothingSent();
        $this->assertSame('Pending', $appointment->fresh()->status);
    }
}
