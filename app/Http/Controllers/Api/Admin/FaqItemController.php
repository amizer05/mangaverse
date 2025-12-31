<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqItemResource;
use App\Models\FaqItem;
use Illuminate\Http\Request;

class FaqItemController extends Controller
{
    public function index()
    {
        $items = FaqItem::with('faqCategory')->latest()->paginate(15);
        return FaqItemResource::collection($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        $item = FaqItem::create($validated);
        $item->load('faqCategory');
        return new FaqItemResource($item);
    }

    public function show(FaqItem $faqItem)
    {
        $faqItem->load('faqCategory');
        return new FaqItemResource($faqItem);
    }

    public function update(Request $request, FaqItem $faqItem)
    {
        $validated = $request->validate([
            'faq_category_id' => ['sometimes', 'required', 'exists:faq_categories,id'],
            'question' => ['sometimes', 'required', 'string', 'max:255'],
            'answer' => ['sometimes', 'required', 'string'],
        ]);

        $faqItem->update($validated);
        $faqItem->load('faqCategory');
        return new FaqItemResource($faqItem->fresh());
    }

    public function destroy(FaqItem $faqItem)
    {
        $faqItem->delete();
        return response()->json(['message' => 'FAQ item deleted successfully']);
    }
}
