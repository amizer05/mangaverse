<?php

namespace App\Http\Controllers;

use App\Models\FaqRequest;
use Illuminate\Http\Request;

class FaqRequestController extends Controller
{
    /**
     * Store a newly created FAQ request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'question' => ['required', 'string', 'max:500'],
        ]);

        FaqRequest::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'question' => $request->question,
            'status' => 'pending',
        ]);

        return redirect()->route('faq.index')->with('success', 'Your question has been submitted! We will review it and add it to the FAQ if appropriate.');
    }
}
