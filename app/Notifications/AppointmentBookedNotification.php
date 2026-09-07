<?php

namespace App\Notifications;

use App\Models\Appointments;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentBookedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Appointments $appointment
    ) {
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toDatabase(object $notifiable): array
    {
        return [
            'appointment_id' =>
                $this->appointment->id,

            'appointment_number' =>
                $this->appointment->appointment_number,

            'event' =>
                'AppointmentBooked',

            'title' =>
                'Appointment request submitted',

            'message' =>
                'Your appointment '
                . $this->appointment->appointment_number
                . ' was submitted successfully.',
        ];
    }
}