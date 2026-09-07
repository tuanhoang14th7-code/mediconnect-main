<?php

namespace Tests\Feature;

use App\Models\AppointmentHistory;
use App\Models\Appointments;
use App\Notifications\AppointmentRescheduledNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\Feature\Concerns\CreatesAppointmentFixtures;
use Tests\TestCase;

/**
 * D04 - Reschedule Notification.
 */
class D04_RescheduleNotificationTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAppointmentFixtures;

    public function test_patient_receives_notification_when_rescheduling_an_appointment(): void
    {
        Notification::fake();

        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $oldSlot = $this->makeSlot($assignment, ['status' => 'Booked']);
        $newSlot = $this->makeSlot($assignment, [
            'slot_date' => today()->addDays(2)->format('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '10:30:00',
        ]);

        $appointment = Appointments::create([
            'appointment_number' => 'APT-TEST-0001',
            'patient_user_id' => $patient->id,
            'facility_specialization_id' => $assignment->facility_specialization_id,
            'doctor_assignment_id' => $assignment->id,
            'slot_id' => $oldSlot->id,
            'patient_name' => $patient->name,
            'patient_phone' => $patient->number,
            'appointment_date' => $oldSlot->slot_date,
            'start_time' => $oldSlot->start_time,
            'end_time' => $oldSlot->end_time,
            'status' => 'Pending',
            'booked_at' => now(),
        ]);

        $response = $this->actingAs($patient)->post(
            "/Patient/Appointments/{$appointment->id}/Reschedule",
            ['slot_id' => $newSlot->id]
        );

        $response->assertRedirect(route('patient.appointments.show', $appointment->id));

        Notification::assertSentTo($patient, AppointmentRescheduledNotification::class);

        $appointment->refresh();
        $this->assertSame($newSlot->id, $appointment->slot_id);
        $this->assertSame('Pending', $appointment->status);
        $this->assertSame('Available', $oldSlot->fresh()->status);
        $this->assertSame('Booked', $newSlot->fresh()->status);
        $this->assertDatabaseHas('appointment_histories', [
            'appointment_id' => $appointment->id,
            'action' => 'Adjusted',
            'new_slot_id' => $newSlot->id,
        ]);
    }

    public function test_cannot_reschedule_to_a_slot_from_a_different_doctor(): void
    {
        Notification::fake();

        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $oldSlot = $this->makeSlot($assignment, ['status' => 'Booked']);

        $otherDoctor = $this->makeDoctorProfile($this->makeDoctorUser(), ['license_number' => 'OTHER-1']);
        $otherAssignment = $this->makeAssignment($otherDoctor);
        $otherSlot = $this->makeSlot($otherAssignment);

        $appointment = Appointments::create([
            'appointment_number' => 'APT-TEST-0002',
            'patient_user_id' => $patient->id,
            'facility_specialization_id' => $assignment->facility_specialization_id,
            'doctor_assignment_id' => $assignment->id,
            'slot_id' => $oldSlot->id,
            'patient_name' => $patient->name,
            'patient_phone' => $patient->number,
            'appointment_date' => $oldSlot->slot_date,
            'start_time' => $oldSlot->start_time,
            'end_time' => $oldSlot->end_time,
            'status' => 'Pending',
            'booked_at' => now(),
        ]);

        $response = $this->actingAs($patient)->post(
            "/Patient/Appointments/{$appointment->id}/Reschedule",
            ['slot_id' => $otherSlot->id]
        );

        $response->assertSessionHasErrors('slot_id');
        Notification::assertNothingSent();
        $this->assertSame($oldSlot->id, $appointment->fresh()->slot_id);
    }
}
