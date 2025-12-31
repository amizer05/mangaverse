<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a contact form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        // Send email notification to admin
        $adminEmail = config('mail.from.address', 'admin@example.com');
        \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\ContactNotification($contact));

        return response()->json([
            'message' => 'Contact form submitted successfully',
            'contact' => [
                'id' => $contact->id,
                'subject' => $contact->subject,
                'created_at' => $contact->created_at->format('Y-m-d H:i:s'),
            ],
        ], 201);
    }
}






