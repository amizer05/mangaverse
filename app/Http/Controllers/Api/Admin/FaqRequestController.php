<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqRequest;
use App\Models\FaqItem;
use Illuminate\Http\Request;

class FaqRequestController extends Controller
{
    public function index()
    {
        $requests = FaqRequest::with(['user', 'reviewer'])->latest()->paginate(15);
        
        return response()->json([
            'data' => $requests->map(function($request) {
                return [
                    'id' => $request->id,
                    'question' => $request->question,
                    'name' => $request->name,
                    'email' => $request->email,
                    'status' => $request->status,
                    'reviewed_by' => $request->reviewer ? $request->reviewer->name : null,
                    'reviewed_at' => $request->reviewed_at?->format('Y-m-d H:i:s'),
                    'created_at' => $request->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'meta' => [
                'current_page' => $requests->currentPage(),
                'last_page' => $requests->lastPage(),
                'per_page' => $requests->perPage(),
                'total' => $requests->total(),
            ],
        ]);
    }

    public function approve(Request $request, FaqRequest $faqRequest)
    {
        $validated = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'answer' => ['required', 'string'],
        ]);

        // Create FAQ item
        $faqItem = FaqItem::create([
            'faq_category_id' => $validated['faq_category_id'],
            'question' => $faqRequest->question,
            'answer' => $validated['answer'],
        ]);

        // Update request status
        $faqRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return response()->json([
            'message' => 'FAQ request approved and added to FAQ',
            'data' => [
                'faq_request' => [
                    'id' => $faqRequest->id,
                    'status' => $faqRequest->status,
                ],
                'faq_item' => [
                    'id' => $faqItem->id,
                    'question' => $faqItem->question,
                ],
            ],
        ]);
    }
}
