<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicChapterController extends Controller
{
    /**
     * Display a chapter for reading.
     */
    public function show(Manga $manga, int $chapter): View
    {
        $chapter = Chapter::where('id', $chapter)
            ->where('manga_id', $manga->id)
            ->where('is_published', true)
            ->firstOrFail();

        // Load pages
        $chapter->load('pages');
        
        // Get next and previous chapters
        $nextChapter = Chapter::where('manga_id', $manga->id)
            ->where('is_published', true)
            ->where('chapter_number', '>', $chapter->chapter_number)
            ->orderBy('chapter_number', 'asc')
            ->first();

        $previousChapter = Chapter::where('manga_id', $manga->id)
            ->where('is_published', true)
            ->where('chapter_number', '<', $chapter->chapter_number)
            ->orderBy('chapter_number', 'desc')
            ->first();

        // Increment views
        $chapter->incrementViews();

        return view('chapters.read', compact('manga', 'chapter', 'nextChapter', 'previousChapter'));
    }

    /**
     * Display a specific page of a chapter.
     */
    public function showPage(Manga $manga, int $chapter, int $pageNumber): View
    {
        $chapter = Chapter::where('id', $chapter)
            ->where('manga_id', $manga->id)
            ->where('is_published', true)
            ->firstOrFail();

        $page = $chapter->pages()->where('page_number', $pageNumber)->firstOrFail();
        
        // Get all pages for navigation
        $allPages = $chapter->pages;
        $currentPageIndex = $allPages->search(function ($p) use ($pageNumber) {
            return $p->page_number === $pageNumber;
        });

        $nextPage = $allPages->get($currentPageIndex + 1);
        $previousPage = $allPages->get($currentPageIndex - 1);

        // Get next and previous chapters
        $nextChapter = Chapter::where('manga_id', $manga->id)
            ->where('is_published', true)
            ->where('chapter_number', '>', $chapter->chapter_number)
            ->orderBy('chapter_number', 'asc')
            ->first();

        $previousChapter = Chapter::where('manga_id', $manga->id)
            ->where('is_published', true)
            ->where('chapter_number', '<', $chapter->chapter_number)
            ->orderBy('chapter_number', 'desc')
            ->first();

        return view('chapters.read-page', compact('manga', 'chapter', 'page', 'allPages', 'nextPage', 'previousPage', 'nextChapter', 'previousChapter', 'pageNumber'));
    }
}
