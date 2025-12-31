<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Http\Request;

class FaqItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqItems = FaqItem::with('faqCategory')->latest()->paginate(10);

        return view('admin.faq-items.index', compact('faqItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FaqCategory::all();
        return view('admin.faq-items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        FaqItem::create($request->all());

        return redirect()->route('admin.faq-items.index')->with('success', 'FAQ Item created');
    }

    /**
     * Display the specified resource.
     */
    public function show(FaqItem $faqItem)
    {
        $faqItem->load('faqCategory');
        return view('admin.faq-items.show', compact('faqItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaqItem $faqItem)
    {
        $categories = FaqCategory::all();
        return view('admin.faq-items.edit', compact('faqItem', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FaqItem $faqItem)
    {
        $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        $faqItem->update($request->all());

        return redirect()->route('admin.faq-items.index')->with('success', 'FAQ Item updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqItem $faqItem)
    {
        $faqItem->delete();

        return redirect()->route('admin.faq-items.index')->with('success', 'FAQ Item deleted');
    }
}
