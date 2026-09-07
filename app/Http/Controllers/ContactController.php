<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    // Show Contact page
    public function show()
    {
        return view('contact');
    }


    // Submit Contact message
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'subject' => [
                'nullable',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);


        ContactMessage::create([
            'user_id' =>
                Auth::id(),

            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'phone' =>
                $validated['phone'],

            'subject' =>
                $validated['subject'] ?? null,

            'message' =>
                $validated['message'],

            'status' =>
                'New',
        ]);


        return redirect()
            ->route('contact')
            ->with(
                'success',
                'Your message has been sent successfully.'
            );
    }
}