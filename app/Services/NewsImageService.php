<?php

namespace App\Services;

use App\Models\News;
use App\Models\Manga;
use App\Services\MangaApiService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsImageService
{
    /**
     * Find and assign relevant manga cover to news item.
     */
    public function assignRelevantMangaImage(News $news): ?string
    {
        // Extract manga titles from news content
        $mangaTitles = $this->extractMangaTitles($news);
        
        // Try to find matching manga in database
        foreach ($mangaTitles as $title) {
            $manga = Manga::where('title', 'like', '%' . $title . '%')
                ->orWhere('slug', 'like', '%' . Str::slug($title) . '%')
                ->first();
            
            if ($manga && $manga->cover_image && Storage::disk('public')->exists($manga->cover_image)) {
                // Copy manga cover to news images
                $newPath = $this->copyMangaCoverToNews($manga->cover_image, $news);
                return $newPath;
            }
        }

        // If no match found, try to find from API
        foreach ($mangaTitles as $title) {
            try {
                $apiService = new MangaApiService();
                $results = $apiService->searchManga($title, 1);
                
                if (!empty($results)) {
                    $apiData = $results[0];
                    if (isset($apiData['images']['jpg']['large_image_url'])) {
                        $imagePath = $this->downloadNewsImageFromUrl(
                            $apiData['images']['jpg']['large_image_url'],
                            $news
                        );
                        if ($imagePath) {
                            return $imagePath;
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error fetching from API for news: ' . $e->getMessage());
            }
            
            // Rate limiting
            usleep(500000);
        }

        return null;
    }

    /**
     * Assign a specific manga cover to a news item.
     */
    public function assignMangaToNews(News $news, Manga $manga): bool
    {
        if (!$manga->cover_image || !Storage::disk('public')->exists($manga->cover_image)) {
            return false;
        }

        $newPath = $this->copyMangaCoverToNews($manga->cover_image, $news);
        
        if ($newPath) {
            $news->update(['image' => $newPath]);
            return true;
        }

        return false;
    }

    /**
     * Extract potential manga titles from news content.
     */
    private function extractMangaTitles(News $news): array
    {
        $text = strtolower($news->title . ' ' . strip_tags($news->content));
        $titles = [];

        // Get all manga from database first (most accurate)
        $allManga = Manga::pluck('title')->toArray();
        foreach ($allManga as $mangaTitle) {
            $mangaLower = strtolower($mangaTitle);
            // Check for exact match or partial match
            if (stripos($text, $mangaLower) !== false || 
                stripos($text, str_replace(' ', '', $mangaLower)) !== false) {
                $titles[] = $mangaTitle;
            }
        }

        // Also check for common manga titles
        $popularManga = [
            'One Piece', 'Naruto', 'Attack on Titan', 'Demon Slayer', 'My Hero Academia',
            'Death Note', 'Jujutsu Kaisen', 'Chainsaw Man', 'Spy x Family', 'One Punch Man',
            'Dragon Ball', 'Bleach', 'Berserk', 'Tokyo Ghoul', 'Fullmetal Alchemist',
            'Hunter x Hunter', 'Fairy Tail', 'Black Clover', 'Dr. Stone', 'The Promised Neverland',
            'Haikyuu', 'Kuroko no Basket', 'Slam Dunk', 'JoJo', 'JoJo\'s Bizarre Adventure',
            'Mob Psycho', 'Vinland Saga', 'Kingdom', 'One Punch', 'Spy Family'
        ];

        foreach ($popularManga as $manga) {
            $mangaLower = strtolower($manga);
            if (stripos($text, $mangaLower) !== false) {
                $titles[] = $manga;
            }
        }

        return array_unique($titles);
    }

    /**
     * Copy manga cover to news images directory.
     */
    private function copyMangaCoverToNews(string $mangaCoverPath, News $news): string
    {
        $sourcePath = storage_path('app/public/' . $mangaCoverPath);
        
        if (!file_exists($sourcePath)) {
            return null;
        }

        $extension = pathinfo($mangaCoverPath, PATHINFO_EXTENSION) ?: 'jpg';
        $filename = 'news-' . Str::slug($news->title) . '-' . $news->id . '.' . $extension;
        $destinationPath = 'news-images/' . $filename;

        // Copy file
        $content = file_get_contents($sourcePath);
        Storage::disk('public')->put($destinationPath, $content);

        return $destinationPath;
    }

    /**
     * Download image from URL for news item.
     */
    private function downloadNewsImageFromUrl(string $url, News $news): ?string
    {
        try {
            $imageContent = @file_get_contents($url);
            
            if ($imageContent === false) {
                return null;
            }

            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = 'news-' . Str::slug($news->title) . '-' . $news->id . '.' . $extension;
            $path = 'news-images/' . $filename;

            Storage::disk('public')->put($path, $imageContent);

            return $path;
        } catch (\Exception $e) {
            \Log::error('Error downloading news image: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Assign images to all news items without images.
     */
    public function assignImagesToAllNews(): array
    {
        $newsItems = News::whereNull('image')->orWhere('image', '')->get();
        $results = ['assigned' => 0, 'failed' => 0];

        // Get all manga with covers as fallback
        $mangaWithCovers = Manga::whereNotNull('cover_image')
            ->where('cover_image', '!=', '')
            ->get();

        foreach ($newsItems as $index => $news) {
            $imagePath = $this->assignRelevantMangaImage($news);
            
            // If no specific match, use a random popular manga cover
            if (!$imagePath && $mangaWithCovers->isNotEmpty()) {
                $randomManga = $mangaWithCovers->random();
                $imagePath = $this->copyMangaCoverToNews($randomManga->cover_image, $news);
            }
            
            if ($imagePath) {
                $news->update(['image' => $imagePath]);
                $results['assigned']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }
}

