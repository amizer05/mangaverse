<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified contact message.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update the status of a contact message.
     */
    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => ['required', 'in:new,read,answered'],
        ]);

        $contact->update(['status' => $request->status]);

        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Status updated');
    }

    /**
     * Reply to a contact message.
     */
    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'admin_reply' => ['required', 'string'],
        ]);

        $contact->update([
            'admin_reply' => $request->admin_reply,
            'replied_by' => auth()->id(),
            'replied_at' => now(),
            'status' => 'answered',
        ]);

        // Send email reply to user
        try {
            \Illuminate\Support\Facades\Mail::to($contact->email)->send(
                new \App\Mail\ContactReply($contact)
            );
        } catch (\Exception $e) {
            // Email might fail but still save the reply
            // Could log this later if needed
        }

        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Reply sent successfully');
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact message deleted');
    }
}
