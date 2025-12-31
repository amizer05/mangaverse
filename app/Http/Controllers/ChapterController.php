<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\ChapterPage;
use App\Models\Manga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ChapterController extends Controller
{
    /**
     * Display a listing of chapters for a manga.
     */
    public function index(Manga $manga): View
    {
        $chapters = $manga->chapters()
            ->orderBy('chapter_number', 'desc')
            ->orderBy('language', 'asc')
            ->paginate(20);

        return view('admin.chapters.index', compact('manga', 'chapters'));
    }

    /**
     * Show the form for creating a new chapter.
     */
    public function create(Manga $manga): View
    {
        return view('admin.chapters.create', compact('manga'));
    }

    /**
     * Store a newly created chapter.
     */
    public function store(Request $request, Manga $manga): RedirectResponse
    {
        $request->validate([
            'chapter_number' => ['required', 'integer', 'min:1'],
            'title' => ['nullable', 'string', 'max:255'],
            'language' => ['required', 'in:VF,VO,EN'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'pages' => ['required_without:page_urls', 'array', 'min:1'],
            'pages.*' => ['required_without:page_urls', 'image', 'mimes:jpeg,jpg,png,webp', 'max:10240'], // Max 10MB per image
            'page_urls' => ['required_without:pages', 'array', 'min:1'],
            'page_urls.*' => ['required_without:pages', 'url', 'max:500'],
        ]);

        // Check for duplicate chapter number and language
        $existingChapter = Chapter::where('manga_id', $manga->id)
            ->where('chapter_number', $request->chapter_number)
            ->where('language', $request->language)
            ->first();

        if ($existingChapter) {
            return back()->withErrors(['chapter_number' => 'A chapter with this number and language already exists.'])->withInput();
        }

        $chapter = Chapter::create([
            'manga_id' => $manga->id,
            'chapter_number' => $request->chapter_number,
            'title' => $request->title,
            'language' => $request->language,
            'page_count' => count($request->pages),
            'is_published' => $request->has('is_published'),
            'published_at' => $request->published_at ?? ($request->has('is_published') ? now() : null),
        ]);

        // Upload and store pages
        if ($request->has('pages') && is_array($request->pages)) {
            // Handle file uploads
            foreach ($request->pages as $index => $pageFile) {
                $pageNumber = $index + 1;
                $path = $pageFile->store("chapters/{$manga->slug}/{$chapter->id}", 'public');
                
                ChapterPage::create([
                    'chapter_id' => $chapter->id,
                    'page_number' => $pageNumber,
                    'image_path' => $path,
                ]);
            }
        } elseif ($request->has('page_urls') && is_array($request->page_urls)) {
            // Handle URL downloads
            foreach ($request->page_urls as $index => $url) {
                if (empty($url)) continue;
                
                $pageNumber = $index + 1;
                // Download image from URL
                $imageContent = @file_get_contents($url);
                
                if ($imageContent === false) {
                    continue; // Skip if fails
                }
                
                // Get extension from URL - simple way
                $extension = 'jpg';
                $urlPath = parse_url($url, PHP_URL_PATH);
                if ($urlPath) {
                    $ext = pathinfo($urlPath, PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
                        $extension = strtolower($ext);
                    }
                }
                
                $filename = "page_{$pageNumber}." . $extension;
                $path = "chapters/{$manga->slug}/{$chapter->id}/{$filename}";
                
                try {
                    Storage::disk('public')->put($path, $imageContent);
                    
                    ChapterPage::create([
                        'chapter_id' => $chapter->id,
                        'page_number' => $pageNumber,
                        'image_path' => $path,
                    ]);
                } catch (\Exception $e) {
                    // Log error but continue with other URLs
                    \Log::warning("Failed to save chapter page from URL: {$url}", ['error' => $e->getMessage()]);
                    continue;
                }
            }
        }

        return redirect()->route('admin.mangas.chapters.index', $manga)
            ->with('success', 'Chapter created successfully!');
    }

    /**
     * Display the specified chapter.
     */
    public function show(Manga $manga, Chapter $chapter): View
    {
        $chapter->load('pages');
        return view('admin.chapters.show', compact('manga', 'chapter'));
    }

    /**
     * Show the form for editing the specified chapter.
     */
    public function edit(Manga $manga, Chapter $chapter): View
    {
        $chapter->load('pages');
        return view('admin.chapters.edit', compact('manga', 'chapter'));
    }

    /**
     * Update the specified chapter.
     */
    public function update(Request $request, Manga $manga, Chapter $chapter): RedirectResponse
    {
        $request->validate([
            'chapter_number' => ['required', 'integer', 'min:1'],
            'title' => ['nullable', 'string', 'max:255'],
            'language' => ['required', 'in:VF,VO,EN'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'new_pages' => ['nullable', 'array'],
            'new_pages.*' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:10240'],
        ]);

        // Check for duplicate chapter number and language (excluding current chapter)
        $existingChapter = Chapter::where('manga_id', $manga->id)
            ->where('chapter_number', $request->chapter_number)
            ->where('language', $request->language)
            ->where('id', '!=', $chapter->id)
            ->first();

        if ($existingChapter) {
            return back()->withErrors(['chapter_number' => 'A chapter with this number and language already exists.'])->withInput();
        }

        $chapter->update([
            'chapter_number' => $request->chapter_number,
            'title' => $request->title,
            'language' => $request->language,
            'is_published' => $request->has('is_published'),
            'published_at' => $request->published_at ?? ($request->has('is_published') ? now() : null),
        ]);

        // Add new pages if provided
        if ($request->has('new_pages')) {
            $currentPageCount = $chapter->pages()->count();
            foreach ($request->new_pages as $index => $pageFile) {
                $pageNumber = $currentPageCount + $index + 1;
                $path = $pageFile->store("chapters/{$manga->slug}/{$chapter->id}", 'public');
                
                ChapterPage::create([
                    'chapter_id' => $chapter->id,
                    'page_number' => $pageNumber,
                    'image_path' => $path,
                ]);
            }
            
            $chapter->update(['page_count' => $chapter->pages()->count()]);
        }

        return redirect()->route('admin.mangas.chapters.index', $manga)
            ->with('success', 'Chapter updated successfully!');
    }

    /**
     * Remove the specified chapter.
     */
    public function destroy(Manga $manga, Chapter $chapter): RedirectResponse
    {
        // Delete all page images
        foreach ($chapter->pages as $page) {
            if (Storage::disk('public')->exists($page->image_path)) {
                Storage::disk('public')->delete($page->image_path);
            }
        }

        $chapter->delete();

        return redirect()->route('admin.mangas.chapters.index', $manga)
            ->with('success', 'Chapter deleted successfully!');
    }

    /**
     * Delete a specific page from a chapter.
     */
    public function deletePage(Manga $manga, Chapter $chapter, ChapterPage $page): RedirectResponse
    {
        if ($page->chapter_id !== $chapter->id) {
            abort(404);
        }

        // Delete image file
        if (Storage::disk('public')->exists($page->image_path)) {
            Storage::disk('public')->delete($page->image_path);
        }

        $page->delete();

        // Reorder remaining pages
        $remainingPages = $chapter->pages()->orderBy('page_number')->get();
        foreach ($remainingPages as $index => $remainingPage) {
            $remainingPage->update(['page_number' => $index + 1]);
        }

        $chapter->update(['page_count' => $chapter->pages()->count()]);

        return back()->with('success', 'Page deleted successfully!');
    }
}
