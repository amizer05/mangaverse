<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqCategoryResource;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of FAQ categories with items.
     */
    public function index()
    {
        $categories = FaqCategory::with('faqItems')->get();

        return FaqCategoryResource::collection($categories);
    }
}






