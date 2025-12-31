<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MangaApiService
{
    /**
     * Base URL for Jikan API (MyAnimeList)
     */
    private const BASE_URL = 'https://api.jikan.moe/v4';

    /**
     * Cache duration in minutes
     */
    private const CACHE_DURATION = 60 * 24; // 24 hours

    /**
     * Search for manga by title.
     */
    public function searchManga(string $query, int $limit = 10): array
    {
        $cacheKey = "manga_search_{$query}_{$limit}";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($query, $limit) {
            try {
                $response = Http::timeout(10)->get(self::BASE_URL . '/manga', [
                    'q' => $query,
                    'limit' => $limit,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['data'] ?? [];
                }
            } catch (\Exception $e) {
                \Log::error('Manga API search error: ' . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Get manga details by MyAnimeList ID.
     */
    public function getMangaById(int $malId): ?array
    {
        $cacheKey = "manga_{$malId}";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($malId) {
            try {
                $response = Http::timeout(10)->get(self::BASE_URL . "/manga/{$malId}");

                if ($response->successful()) {
                    return $response->json()['data'] ?? null;
                }
            } catch (\Exception $e) {
                \Log::error('Manga API get error: ' . $e->getMessage());
            }

            return null;
        });
    }

    /**
     * Get top/popular manga.
     */
    public function getTopManga(int $limit = 20, string $type = 'manga'): array
    {
        $cacheKey = "manga_top_{$type}_{$limit}";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($limit, $type) {
            try {
                $response = Http::timeout(10)->get(self::BASE_URL . "/top/{$type}", [
                    'limit' => $limit,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['data'] ?? [];
                }
            } catch (\Exception $e) {
                \Log::error('Manga API top error: ' . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Download and store manga cover image.
     * Simple download from URL
     */
    public function downloadCoverImage(string $imageUrl, string $slug): ?string
    {
        // Download image using file_get_contents - simpler approach
        $imageContent = @file_get_contents($imageUrl);
        
        if ($imageContent === false) {
            return null;
        }

        // Get extension from URL
        $extension = $this->getImageExtension($imageUrl);
        $filename = "{$slug}.{$extension}";
        $path = "manga-covers/{$filename}";

        // Save to storage
        Storage::disk('public')->put($path, $imageContent);

        return $path;
    }

    /**
     * Sync manga data from API to database.
     */
    public function syncMangaFromApi(array $apiData, ?\App\Models\Manga $manga = null, bool $forceUpdate = false): \App\Models\Manga
    {
        $title = $apiData['title'] ?? $apiData['title_english'] ?? 'Unknown';
        $slug = $manga?->slug ?? Str::slug($title);

        // Check if manga with this slug already exists
        if (!$manga) {
            $manga = \App\Models\Manga::where('slug', $slug)->first();
        }

        // If still no manga, try to find by similar title
        if (!$manga) {
            $englishTitle = $apiData['title_english'] ?? null;
            $japaneseTitle = $apiData['title_japanese'] ?? null;
            
            // Try to find by English title
            if ($englishTitle) {
                $manga = \App\Models\Manga::where('title', 'like', '%' . $englishTitle . '%')
                    ->orWhere('title', 'like', '%' . $title . '%')
                    ->first();
            }
        }

        $data = [
            'title' => $manga?->title ?? $title, // Keep existing title if manga exists
            'slug' => $manga?->slug ?? $slug, // Keep existing slug if manga exists
            'description' => $this->extractDescription($apiData),
            'genre' => $this->extractGenre($apiData),
            'release_date' => $this->extractReleaseDate($apiData),
        ];

        // Download cover image if available and not already set (or if updating)
        if (isset($apiData['images']['jpg']['large_image_url'])) {
            // Always update cover if manga doesn't have one, or if we're explicitly updating
            $needsCover = !$manga?->cover_image || 
                         !Storage::disk('public')->exists($manga->cover_image) ||
                         $forceUpdate;
            
            if ($needsCover) {
                $coverPath = $this->downloadCoverImage(
                    $apiData['images']['jpg']['large_image_url'],
                    $manga?->slug ?? $slug
                );
                if ($coverPath) {
                    $data['cover_image'] = $coverPath;
                }
            }
        }

        if ($manga) {
            $manga->update($data);
            return $manga;
        }

        return \App\Models\Manga::create($data);
    }

    /**
     * Find manga by title and sync.
     */
    public function findAndSyncManga(string $title): ?\App\Models\Manga
    {
        $results = $this->searchManga($title, 1);
        
        if (!empty($results)) {
            $apiData = $results[0];
            $malId = $apiData['mal_id'] ?? null;
            
            if ($malId) {
                $fullData = $this->getMangaById($malId);
                if ($fullData) {
                    return $this->syncMangaFromApi($fullData);
                }
            }
        }

        return null;
    }

    /**
     * Extract description from API data.
     */
    private function extractDescription(array $apiData): string
    {
        return $apiData['synopsis'] ?? 
               $apiData['background'] ?? 
               'No description available.';
    }

    /**
     * Extract genre from API data.
     */
    private function extractGenre(array $apiData): ?string
    {
        if (isset($apiData['genres']) && is_array($apiData['genres']) && !empty($apiData['genres'])) {
            return $apiData['genres'][0]['name'] ?? null;
        }
        return null;
    }

    /**
     * Extract release date from API data.
     */
    private function extractReleaseDate(array $apiData): ?string
    {
        if (isset($apiData['published']['from'])) {
            return date('Y-m-d', strtotime($apiData['published']['from']));
        }
        return null;
    }

    /**
     * Get image extension from URL.
     */
    private function getImageExtension(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return in_array($extension, ['jpg', 'jpeg', 'png', 'webp']) ? $extension : 'jpg';
    }

    /**
     * Get manga statistics.
     */
    public function getMangaStats(int $malId): ?array
    {
        $cacheKey = "manga_stats_{$malId}";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($malId) {
            try {
                $response = Http::timeout(10)->get(self::BASE_URL . "/manga/{$malId}/statistics");

                if ($response->successful()) {
                    return $response->json()['data'] ?? null;
                }
            } catch (\Exception $e) {
                \Log::error('Manga API stats error: ' . $e->getMessage());
            }

            return null;
        });
    }
}

