<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of chapters for a manga.
     */
    public function index(Manga $manga)
    {
        $chapters = $manga->chapters()
            ->where('is_published', true)
            ->orderBy('chapter_number')
            ->get();

        return ChapterResource::collection($chapters);
    }

    /**
     * Display the specified chapter.
     */
    public function show(Manga $manga, Chapter $chapter)
    {
        if ($chapter->manga_id !== $manga->id) {
            return response()->json(['message' => 'Chapter not found for this manga'], 404);
        }

        $chapter->load('pages');
        $chapter->incrementViews();

        return new ChapterResource($chapter);
    }
}






