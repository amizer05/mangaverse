<?php

namespace App\Http\Controllers;

use App\Mail\ContactNotification;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function create()
    {
        $user = auth()->user();
        $prefilledData = $user ? [
            'name' => $user->name,
            'email' => $user->email,
        ] : [];

        return view('contact.create', compact('prefilledData'));
    }

    /**
     * Handle contact form submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new',
            'is_read' => false,
        ]);

        // Send email to admin
        // TODO: maybe make this configurable later
        $adminEmail = config('mail.from.address', 'admin@example.com');
        try {
            Mail::to($adminEmail)->send(new ContactNotification($contact));
        } catch (\Exception $e) {
            // If email fails, still save the contact
            // Log error but don't break the flow
        }

        return redirect()->route('contact.create')->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
