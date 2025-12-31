<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MangaResource;
use App\Models\Manga;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    /**
     * Display a listing of mangas.
     */
    public function index(Request $request)
    {
        $query = Manga::query();

        // Filter by genre
        if ($request->has('genre')) {
            $query->where('genre', $request->genre);
        }

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->popular();
                break;
            case 'title':
                $query->orderBy('title');
                break;
            default:
                $query->latest();
        }

        $mangas = $query->withCount(['chapters' => function($q) {
            $q->where('is_published', true);
        }])->paginate($request->get('per_page', 15));

        return MangaResource::collection($mangas);
    }

    /**
     * Display the specified manga.
     */
    public function show(Manga $manga)
    {
        $manga->load(['chapters' => function($q) {
            $q->where('is_published', true)->orderBy('chapter_number');
        }]);

        return new MangaResource($manga);
    }

    /**
     * Add manga to favorites.
     */
    public function favorite(Request $request, Manga $manga)
    {
        $user = $request->user();
        
        if (!$user->favorites()->where('manga_id', $manga->id)->exists()) {
            $user->favorites()->attach($manga->id);
        }

        return response()->json([
            'message' => 'Manga added to favorites',
        ]);
    }

    /**
     * Remove manga from favorites.
     */
    public function unfavorite(Request $request, Manga $manga)
    {
        $user = $request->user();
        $user->favorites()->detach($manga->id);

        return response()->json([
            'message' => 'Manga removed from favorites',
        ]);
    }
}






