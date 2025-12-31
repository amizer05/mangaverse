<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('replier')->latest()->paginate(15);
        
        return response()->json([
            'data' => $contacts->map(function($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'subject' => $contact->subject,
                    'message' => $contact->message,
                    'status' => $contact->status,
                    'admin_reply' => $contact->admin_reply,
                    'replied_by' => $contact->replier ? $contact->replier->name : null,
                    'replied_at' => $contact->replied_at?->format('Y-m-d H:i:s'),
                    'created_at' => $contact->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'meta' => [
                'current_page' => $contacts->currentPage(),
                'last_page' => $contacts->lastPage(),
                'per_page' => $contacts->perPage(),
                'total' => $contacts->total(),
            ],
        ]);
    }

    public function show(Contact $contact)
    {
        $contact->load('replier');
        
        return response()->json([
            'data' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'status' => $contact->status,
                'admin_reply' => $contact->admin_reply,
                'replied_by' => $contact->replier ? [
                    'id' => $contact->replier->id,
                    'name' => $contact->replier->name,
                ] : null,
                'replied_at' => $contact->replied_at?->format('Y-m-d H:i:s'),
                'created_at' => $contact->created_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'admin_reply' => ['required', 'string'],
        ]);

        $contact->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_by' => auth()->id(),
            'replied_at' => now(),
            'status' => 'answered',
        ]);

        // Send email reply to user
        \Illuminate\Support\Facades\Mail::to($contact->email)->send(
            new \App\Mail\ContactReply($contact)
        );

        return response()->json([
            'message' => 'Reply sent successfully',
            'data' => [
                'id' => $contact->id,
                'admin_reply' => $contact->admin_reply,
                'replied_at' => $contact->replied_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
