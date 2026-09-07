<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Show current patient's notifications
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderByDesc('created_at')
            ->get();

        return view(
            'patient.PatientNotifications',
            compact('notifications')
        );
    }


    // Mark one notification as read
    public function markAsRead($id)
    {
        $user = Auth::user();

        $notification = $user->notifications()
            ->where('id', $id)
            ->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return back();
    }


    // Mark all notifications as read
    public function markAllAsRead()
    {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();

        return back()
            ->with(
                'success',
                'All notifications marked as read.'
            );
    }
}