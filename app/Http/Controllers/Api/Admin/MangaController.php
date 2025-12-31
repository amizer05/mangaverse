<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MangaResource;
use App\Models\Manga;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function index()
    {
        $mangas = Manga::withCount('chapters')->latest()->paginate(15);
        return MangaResource::collection($mangas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:mangas'],
            'description' => ['required', 'string'],
            'genre' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string'],
            'release_date' => ['nullable', 'date'],
        ]);

        $manga = Manga::create($validated);
        return new MangaResource($manga);
    }

    public function show(Manga $manga)
    {
        return new MangaResource($manga);
    }

    public function update(Request $request, Manga $manga)
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:mangas,slug,' . $manga->id],
            'description' => ['sometimes', 'required', 'string'],
            'genre' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string'],
            'release_date' => ['nullable', 'date'],
        ]);

        $manga->update($validated);
        return new MangaResource($manga->fresh());
    }

    public function destroy(Manga $manga)
    {
        $manga->delete();
        return response()->json(['message' => 'Manga deleted successfully']);
    }
}
