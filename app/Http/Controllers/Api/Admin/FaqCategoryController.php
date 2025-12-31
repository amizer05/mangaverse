<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqCategoryResource;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::withCount('faqItems')->latest()->get();
        return FaqCategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category = FaqCategory::create($validated);
        return new FaqCategoryResource($category);
    }

    public function show(FaqCategory $faqCategory)
    {
        $faqCategory->load('faqItems');
        return new FaqCategoryResource($faqCategory);
    }

    public function update(Request $request, FaqCategory $faqCategory)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $faqCategory->update($validated);
        return new FaqCategoryResource($faqCategory->fresh());
    }

    public function destroy(FaqCategory $faqCategory)
    {
        $faqCategory->delete();
        return response()->json(['message' => 'FAQ category deleted successfully']);
    }
}
