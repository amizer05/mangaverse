<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::latest()->paginate(10);

        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'], // Max 5MB
            'image_url' => ['nullable', 'string', 'url', 'max:500'],
            'content' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data = $request->except(['image', 'image_url', 'manga_cover']);

        // Handle manga cover assignment - copy the cover image to news
        if ($request->filled('manga_cover')) {
            $manga = \App\Models\Manga::find($request->manga_cover);
            if ($manga && $manga->cover_image) {
                // Copy the manga cover to news images folder
                $sourcePath = storage_path('app/public/' . $manga->cover_image);
                if (file_exists($sourcePath)) {
                    $extension = pathinfo($manga->cover_image, PATHINFO_EXTENSION);
                    $filename = 'news-' . time() . '-' . uniqid() . '.' . $extension;
                    $destinationPath = 'news-images/' . $filename;
                    copy($sourcePath, storage_path('app/public/' . $destinationPath));
                    $data['image'] = $destinationPath;
                }
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news-images', 'public');
        } elseif ($request->filled('image_url')) {
            // Download image from URL - simple way
            $imageContent = @file_get_contents($request->image_url);
            if ($imageContent !== false) {
                $extension = pathinfo(parse_url($request->image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                if (empty($extension)) {
                    $extension = 'jpg'; // default
                }
                $filename = 'news-' . time() . '-' . uniqid() . '.' . $extension;
                $path = 'news-images/' . $filename;
                \Storage::disk('public')->put($path, $imageContent);
                $data['image'] = $path;
            }
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News created');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'image_url' => ['nullable', 'string', 'url', 'max:500'],
            'content' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data = $request->except(['image', 'image_url', 'manga_cover']);

        // Handle manga cover assignment
        if ($request->filled('manga_cover')) {
            $manga = \App\Models\Manga::find($request->manga_cover);
            if ($manga && $manga->cover_image) {
                // Copy manga cover to news
                $sourcePath = storage_path('app/public/' . $manga->cover_image);
                if (file_exists($sourcePath)) {
                    $extension = pathinfo($manga->cover_image, PATHINFO_EXTENSION);
                    $filename = 'news-' . time() . '-' . uniqid() . '.' . $extension;
                    $destinationPath = 'news-images/' . $filename;
                    copy($sourcePath, storage_path('app/public/' . $destinationPath));
                    $data['image'] = $destinationPath;
                }
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image) {
                $oldPath = storage_path('app/public/' . $news->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $data['image'] = $request->file('image')->store('news-images', 'public');
        } elseif ($request->filled('image_url')) {
            // Download from URL
            $imageContent = @file_get_contents($request->image_url);
            if ($imageContent !== false) {
                $extension = pathinfo(parse_url($request->image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                if (empty($extension)) {
                    $extension = 'jpg';
                }
                $filename = 'news-' . time() . '-' . uniqid() . '.' . $extension;
                $path = 'news-images/' . $filename;
                \Storage::disk('public')->put($path, $imageContent);
                
                // Delete old image
                if ($news->image) {
                    $oldPath = storage_path('app/public/' . $news->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                
                $data['image'] = $path;
            }
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted');
    }

    /**
     * Display a public listing of news.
     */
    public function indexPublic()
    {
        $news = News::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(12);

        return view('news.index-public', compact('news'));
    }

    /**
     * Display a public news item.
     */
    public function showPublic(News $news)
    {
        $relatedNews = News::where('id', '!=', $news->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(3)
            ->get();

        $comments = $news->comments()->with('user')->latest()->paginate(10);

        return view('news.show-public', compact('news', 'relatedNews', 'comments'));
    }
}
