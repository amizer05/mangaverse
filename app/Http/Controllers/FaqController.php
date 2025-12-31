<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Display the public FAQ page.
     */
    public function index(\Illuminate\Http\Request $request): View
    {
        $query = $request->get('q', '');
        
        $categories = FaqCategory::with(['faqItems' => function($q) use ($query) {
            if ($query) {
                $q->where('question', 'like', '%' . $query . '%')
                  ->orWhere('answer', 'like', '%' . $query . '%');
            }
        }])->get();

        // Filter out categories with no matching items if searching
        if ($query) {
            $categories = $categories->filter(function($category) {
                return $category->faqItems->count() > 0;
            });
        }

        return view('faq.index', compact('categories', 'query'));
    }
}
