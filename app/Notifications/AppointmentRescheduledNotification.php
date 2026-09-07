<?php

namespace App\Notifications;

use App\Models\Appointments;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentRescheduledNotification extends Notification
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
                'AppointmentRescheduled',

            'title' =>
                'Appointment rescheduled',

            'message' =>
                'Your appointment '
                . $this->appointment->appointment_number
                . ' has been rescheduled successfully.',
        ];
    }
}