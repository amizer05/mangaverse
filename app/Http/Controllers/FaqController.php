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
        
        // Get all categories with their items
        $categories = FaqCategory::with('faqItems')->get();
        
        // If searching, filter items by query (case-insensitive)
        if ($query) {
            $searchQuery = strtolower($query);
            $categories = $categories->map(function($category) use ($searchQuery) {
                $category->faqItems = $category->faqItems->filter(function($item) use ($searchQuery) {
                    return str_contains(strtolower($item->question), $searchQuery) || 
                           str_contains(strtolower($item->answer), $searchQuery);
                });
                return $category;
            })->filter(function($category) {
                return $category->faqItems->count() > 0;
            });
        }

        return view('faq.index', compact('categories', 'query'));
    }
}
