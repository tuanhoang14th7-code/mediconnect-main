<?php

namespace Tests\Feature;

use App\Notifications\AppointmentBookedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\Feature\Concerns\CreatesAppointmentFixtures;
use Tests\TestCase;

/**
 * D03 - New Booking Notification.
 */
class D03_NewBookingNotificationTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAppointmentFixtures;

    public function test_patient_receives_notification_when_booking_an_appointment(): void
    {
        Notification::fake();

        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $slot = $this->makeSlot($assignment);

        $response = $this->actingAs($patient)->post('/appointments/book', [
            'slot_id' => $slot->id,
            'examination_reason' => 'Checkup',
        ]);

        $response->assertRedirect('/doctors/' . $assignment->id);

        Notification::assertSentTo(
            $patient,
            AppointmentBookedNotification::class
        );

        $this->assertDatabaseHas('appointments', [
            'patient_user_id' => $patient->id,
            'slot_id' => $slot->id,
            'status' => 'Pending',
        ]);
        $this->assertSame('Booked', $slot->fresh()->status);
    }

    public function test_no_notification_is_sent_when_slot_is_already_booked(): void
    {
        Notification::fake();

        $patient = $this->makePatientUser();
        $doctor = $this->makeDoctorProfile($this->makeDoctorUser());
        $assignment = $this->makeAssignment($doctor);
        $slot = $this->makeSlot($assignment, ['status' => 'Booked']);

        $response = $this->actingAs($patient)->post('/appointments/book', [
            'slot_id' => $slot->id,
        ]);

        $response->assertSessionHasErrors('slot_id');
        Notification::assertNothingSent();
    }
}
