<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqRequest;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Http\Request;

class FaqRequestController extends Controller
{
    /**
     * Display a listing of FAQ requests.
     */
    public function index()
    {
        $requests = FaqRequest::with(['user', 'reviewer'])->latest()->paginate(15);

        return view('admin.faq-requests.index', compact('requests'));
    }

    /**
     * Display the specified FAQ request.
     */
    public function show(FaqRequest $faqRequest)
    {
        $faqRequest->load(['user', 'reviewer']);
        $categories = FaqCategory::all();

        return view('admin.faq-requests.show', compact('faqRequest', 'categories'));
    }

    /**
     * Approve a FAQ request and optionally create FAQ item.
     */
    public function approve(Request $request, FaqRequest $faqRequest)
    {
        $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'answer' => ['required', 'string'],
        ]);

        // Create FAQ item
        FaqItem::create([
            'faq_category_id' => $request->faq_category_id,
            'question' => $faqRequest->question,
            'answer' => $request->answer,
        ]);

        // Update request status
        $faqRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.faq-requests.index')->with('success', 'FAQ request approved and added to FAQ');
    }

    /**
     * Reject a FAQ request.
     */
    public function reject(FaqRequest $faqRequest)
    {
        $faqRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.faq-requests.index')->with('success', 'FAQ request rejected');
    }

    /**
     * Remove the specified FAQ request.
     */
    public function destroy(FaqRequest $faqRequest)
    {
        $faqRequest->delete();

        return redirect()->route('admin.faq-requests.index')->with('success', 'FAQ request deleted');
    }
}
