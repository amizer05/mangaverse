<?php

namespace App\Http\Controllers;

use App\Mail\ContactNotification;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

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
        // Honeypot field - if filled, it's a bot
        if ($request->filled('website')) {
            abort(422, 'Spam detected');
        }

        // Rate limiting: max 3 submissions per hour per IP
        $key = 'contact-form:' . $request->ip();
        $maxAttempts = 3;
        $decaySeconds = 3600; // 1 hour

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Too many attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'min:3', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'email.email' => 'Please enter a valid email address.',
            'subject.min' => 'Subject must be at least 3 characters.',
            'subject.max' => 'Subject cannot exceed 255 characters.',
            'message.min' => 'Message must be at least 10 characters.',
            'message.max' => 'Message cannot exceed 2000 characters.',
        ]);

        // Sanitize input to prevent XSS
        $contact = Contact::create([
            'name' => strip_tags($validated['name']),
            'email' => filter_var($validated['email'], FILTER_SANITIZE_EMAIL),
            'subject' => strip_tags($validated['subject']),
            'message' => strip_tags($validated['message']),
            'status' => 'new',
            'is_read' => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Increment rate limiter
        RateLimiter::hit($key, $decaySeconds);

        // Send email to admin (admin@ehb.be as per requirements)
        $adminEmail = 'admin@ehb.be';
        try {
            Mail::to($adminEmail)->send(new ContactNotification($contact));
        } catch (\Exception $e) {
            // If email fails, still save the contact
            // Log error but don't break the flow
            \Log::warning('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->route('contact.create')
            ->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
