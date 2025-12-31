<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource (public).
     */
    public function indexPublic(Request $request)
    {
        $query = Manga::query();

        // Search functionality
        if ($request->has('q') && $request->q) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        // Genre filter (simple string-based genre)
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'popular':
                // Order by popularity (number of published chapters)
                $query->popular();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $mangas = $query->paginate(12)->withQueryString();

        return view('mangas.index-public', compact('mangas'));
    }

    /**
     * Display a listing of the resource (admin).
     */
    public function index()
    {
        $mangas = Manga::latest()->paginate(10);

        return view('mangas.index', compact('mangas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mangas.create');
    }

    /**
     * Search manga from external API (for admin).
     * Using Jikan API to search for manga
     */
    public function searchApi(Request $request)
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2'],
        ]);

        // Call the API directly - simpler approach
        $apiService = new \App\Services\MangaApiService();
        $results = $apiService->searchManga($request->q, 10);

        return response()->json([
            'data' => $results,
        ]);
    }

    /**
     * Sync manga from API (for admin).
     * This syncs manga data from Jikan API
     */
    public function syncFromApi(Request $request)
    {
        $request->validate([
            'title' => ['sometimes', 'string'],
            'mal_id' => ['sometimes', 'integer'],
        ]);

        $apiService = new \App\Services\MangaApiService();

        if ($request->has('mal_id')) {
            $apiData = $apiService->getMangaById($request->mal_id);
            if (!$apiData) {
                return back()->with('error', 'Manga not found');
            }
            $manga = $apiService->syncMangaFromApi($apiData);
        } elseif ($request->has('title')) {
            $manga = $apiService->findAndSyncManga($request->title);
            if (!$manga) {
                return back()->with('error', 'Manga not found');
            }
        } else {
            return back()->with('error', 'Please provide title or mal_id');
        }

        return redirect()->route('admin.mangas.index')->with('success', "Manga '{$manga->title}' synced successfully!");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:mangas,slug'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'], // Max 5MB
            'description' => ['nullable', 'string'],
            'release_date' => ['nullable', 'date'],
        ]);

        $data = $request->all();

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('manga-covers', 'public');
        }

        Manga::create($data);

        return redirect()->route('admin.mangas.index')->with('success', 'Manga created');
    }

    /**
     * Display the specified resource (public).
     */
    public function showPublic(Manga $manga)
    {
        // Load chapters grouped by language
        $chapters = $manga->publishedChapters()
            ->orderBy('chapter_number', 'desc')
            ->get()
            ->groupBy('language');
        
        // Check if user has favorited this manga
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Auth::user()->favorites()->where('manga_id', $manga->id)->exists();
        }
        
        return view('mangas.show-public', compact('manga', 'chapters', 'isFavorited'));
    }

    /**
     * Display the specified resource (admin).
     */
    public function show(Manga $manga)
    {
        return view('mangas.show', compact('manga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manga $manga)
    {
        return view('mangas.edit', compact('manga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manga $manga)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:mangas,slug,' . $manga->id],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'description' => ['nullable', 'string'],
            'release_date' => ['nullable', 'date'],
        ]);

        $data = $request->except(['cover_image']);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover if it exists
            if ($manga->cover_image) {
                $oldPath = storage_path('app/public/' . $manga->cover_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['cover_image'] = $request->file('cover_image')->store('manga-covers', 'public');
        }

        $manga->update($data);

        return redirect()->route('admin.mangas.index')->with('success', 'Manga updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manga $manga)
    {
        $manga->delete();

        return redirect()->route('mangas.index')->with('success', 'Manga deleted');
    }
}
