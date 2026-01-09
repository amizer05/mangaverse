<?php

namespace App\Console\Commands;

use App\Models\Manga;
use App\Services\MangaApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FetchMangaCovers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manga:fetch-covers 
                            {--force : Force re-download even if cover exists}
                            {--skip-existing : Skip mangas that already have covers}
                            {--limit= : Limit number of mangas to process}
                            {--min-size=10 : Minimum file size in KB (re-download smaller files)}
                            {--check-quality : Only check and list manga with poor quality covers}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and download manga cover images from Jikan API (MyAnimeList)';

    /**
     * MangaApiService instance.
     */
    private MangaApiService $apiService;

    /**
     * Popular manga MAL IDs mapping.
     */
    private array $popularMangaMalIds = [
        'one-piece' => 13,
        'naruto' => 11,
        'my-hero-academia' => 75989,
        'demon-slayer' => 106294,
        'attack-on-titan' => 23390,
        'death-note' => 21,
        'jujutsu-kaisen' => 113138,
        'chainsaw-man' => 116778,
        'spy-x-family' => 120089,
        'one-punch-man' => 30276,
        'dragon-ball-z' => 42,
        'bleach' => 12,
    ];

    /**
     * Manual cover URLs for high-quality images (override API results).
     * Format: 'slug' => 'https://direct-url-to-image.jpg'
     * These are direct MyAnimeList CDN URLs for highest quality covers.
     */
    private array $manualCoverUrls = [
        'naruto' => 'https://cdn.myanimelist.net/images/manga/2/253146.jpg',
        'one-piece' => 'https://cdn.myanimelist.net/images/manga/3/55539.jpg',
        'my-hero-academia' => 'https://cdn.myanimelist.net/images/manga/2/191057.jpg',
        'demon-slayer' => 'https://cdn.myanimelist.net/images/manga/1/199351.jpg',
        'attack-on-titan' => 'https://cdn.myanimelist.net/images/manga/2/37846.jpg',
        'death-note' => 'https://cdn.myanimelist.net/images/manga/3/54437.jpg',
        'dragon-ball-z' => 'https://cdn.myanimelist.net/images/manga/1/172262.jpg',
        'bleach' => 'https://cdn.myanimelist.net/images/manga/3/249005.jpg',
        'chainsaw-man' => 'https://cdn.myanimelist.net/images/manga/1/222794.jpg',
        'jujutsu-kaisen' => 'https://cdn.myanimelist.net/images/manga/1/217014.jpg',
        'spy-x-family' => 'https://cdn.myanimelist.net/images/manga/3/223001.jpg',
        'one-punch-man' => 'https://cdn.myanimelist.net/images/manga/1/172262.jpg',
    ];

    /**
     * Genre color mapping for placeholders.
     */
    private array $genreColors = [
        'action' => ['#ef4444', '#dc2626'],
        'adventure' => ['#f59e0b', '#d97706'],
        'comedy' => ['#10b981', '#059669'],
        'drama' => ['#8b5cf6', '#7c3aed'],
        'fantasy' => ['#ec4899', '#db2777'],
        'horror' => ['#1f2937', '#111827'],
        'romance' => ['#f472b6', '#ec4899'],
        'sci-fi' => ['#3b82f6', '#2563eb'],
        'slice-of-life' => ['#14b8a6', '#0d9488'],
        'sports' => ['#22c55e', '#16a34a'],
        'default' => ['#6366f1', '#4f46e5'],
    ];

    /**
     * Execute the console command.
     */
    public function handle(MangaApiService $apiService): int
    {
        $this->apiService = $apiService;

        // Check quality mode
        if ($this->option('check-quality')) {
            return $this->checkQuality();
        }

        $this->info('🎨 Fetching Manga Cover Images');
        $this->info('================================');
        $this->newLine();

        // Get mangas to process
        $query = Manga::query();

        if ($this->option('skip-existing')) {
            $query->whereNull('cover_image')
                  ->orWhere('cover_image', '');
        }

        // Note: min-size filtering is handled in the loop, not in query

        if ($this->option('limit')) {
            $query->limit((int) $this->option('limit'));
        }

        $mangas = $query->get();

        if ($mangas->isEmpty()) {
            $this->warn('No mangas found to process.');
            return 0;
        }

        $this->info("Found {$mangas->count()} manga(s) to process.");
        $this->newLine();

        $bar = $this->output->createProgressBar($mangas->count());
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %message%');
        $bar->start();

        $stats = [
            'downloaded' => 0,
            'skipped' => 0,
            'failed' => 0,
            'placeholder' => 0,
        ];

        $minSizeBytes = $this->option('min-size') ? (int) $this->option('min-size') * 1024 : 0;

        foreach ($mangas as $manga) {
            $bar->setMessage("Processing: {$manga->title}");

            // Check if we should skip based on min-size
            if ($minSizeBytes > 0 && $manga->cover_image) {
                $coverPath = storage_path('app/public/' . $manga->cover_image);
                if (file_exists($coverPath) && filesize($coverPath) >= $minSizeBytes) {
                    $stats['skipped']++;
                    $bar->advance();
                    continue;
                }
            }

            try {
                $result = $this->fetchCoverForManga($manga, $minSizeBytes);
                
                switch ($result) {
                    case 'downloaded':
                        $stats['downloaded']++;
                        break;
                    case 'skipped':
                        $stats['skipped']++;
                        break;
                    case 'placeholder':
                        $stats['placeholder']++;
                        break;
                    case 'failed':
                        $stats['failed']++;
                        break;
                }
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Error processing {$manga->title}: " . $e->getMessage());
                $stats['failed']++;
            }

            $bar->advance();

            // Rate limiting - Jikan API: 3 requests per second
            usleep(350000); // ~0.35 seconds delay
        }

        $bar->finish();
        $this->newLine(2);

        // Display summary
        $this->displaySummary($stats);

        return 0;
    }

    /**
     * Check quality of existing covers.
     */
    private function checkQuality(): int
    {
        $this->info('🔍 Checking Manga Cover Quality');
        $this->info('================================');
        $this->newLine();

        $mangas = Manga::all();
        $poorQuality = [];
        $noCover = [];
        $goodQuality = [];

        $minSizeBytes = 10 * 1024; // 10KB

        foreach ($mangas as $manga) {
            if (!$manga->cover_image) {
                $noCover[] = $manga;
                continue;
            }

            $coverPath = storage_path('app/public/' . $manga->cover_image);
            if (!file_exists($coverPath)) {
                $noCover[] = $manga;
                continue;
            }

            $fileSize = filesize($coverPath);
            if ($fileSize < $minSizeBytes) {
                $poorQuality[] = [
                    'manga' => $manga,
                    'size' => $fileSize,
                ];
            } else {
                $goodQuality[] = $manga;
            }
        }

        $this->info("Total manga: {$mangas->count()}");
        $this->info("✅ Good quality (≥10KB): " . count($goodQuality));
        $this->info("⚠️  Poor quality (<10KB): " . count($poorQuality));
        $this->info("❌ No cover: " . count($noCover));
        $this->newLine();

        if (!empty($poorQuality)) {
            $this->warn('Poor Quality Covers (<10KB):');
            $this->table(
                ['ID', 'Title', 'Size', 'Path'],
                array_map(function($item) {
                    return [
                        $item['manga']->id,
                        $item['manga']->title,
                        number_format($item['size'] / 1024, 2) . ' KB',
                        $item['manga']->cover_image,
                    ];
                }, $poorQuality)
            );
            $this->newLine();
        }

        if (!empty($noCover)) {
            $this->error('Manga Without Covers:');
            $this->table(
                ['ID', 'Title', 'Slug'],
                array_map(function($manga) {
                    return [
                        $manga->id,
                        $manga->title,
                        $manga->slug,
                    ];
                }, $noCover)
            );
            $this->newLine();
        }

        if (!empty($poorQuality) || !empty($noCover)) {
            $this->info('To fix poor quality covers, run:');
            $this->line('  php artisan manga:fetch-covers --min-size=10');
            $this->newLine();
        }

        return 0;
    }

    /**
     * Fetch cover for a single manga.
     */
    private function fetchCoverForManga(Manga $manga, int $minSizeBytes = 0): string
    {
        // Check for manual cover URL first (highest priority)
        // Manual URLs always override, even if cover exists
        if (isset($this->manualCoverUrls[$manga->slug])) {
            // Delete existing cover if it exists (to replace with manual URL)
            if ($manga->cover_image && Storage::disk('public')->exists($manga->cover_image)) {
                $coverPath = storage_path('app/public/' . $manga->cover_image);
                if (file_exists($coverPath)) {
                    @unlink($coverPath);
                }
            }
            
            $this->line("  📥 Using manual cover URL for {$manga->title}");
            $coverPath = $this->downloadManualCover($manga, $this->manualCoverUrls[$manga->slug], $minSizeBytes);
            if ($coverPath) {
                $manga->update(['cover_image' => $coverPath]);
                return 'downloaded';
            }
        }

        // Check if cover already exists and meets quality requirements
        if ($manga->cover_image && Storage::disk('public')->exists($manga->cover_image)) {
            // If force is not set, check if we should skip
            if (!$this->option('force')) {
                // If min-size is specified, check file size
                if ($minSizeBytes > 0) {
                    $coverPath = storage_path('app/public/' . $manga->cover_image);
                    if (file_exists($coverPath)) {
                        $fileSize = filesize($coverPath);
                        // If file meets minimum size, skip
                        if ($fileSize >= $minSizeBytes) {
                            return 'skipped';
                        }
                        // File exists but is too small, delete it and continue
                        $this->line("  ⚠️  Cover too small ({$fileSize} bytes), re-downloading...");
                        @unlink($coverPath);
                    }
                } else {
                    // No min-size requirement, skip if file exists
                    return 'skipped';
                }
            } else {
                // Force mode: delete existing cover to re-download
                $coverPath = storage_path('app/public/' . $manga->cover_image);
                if (file_exists($coverPath)) {
                    @unlink($coverPath);
                }
            }
        }

        // Try to get MAL ID from popular manga mapping or database
        $malId = $manga->mal_id ?? $this->popularMangaMalIds[$manga->slug] ?? null;

        // If no MAL ID, try to search for it
        if (!$malId) {
            $malId = $this->findMalIdByTitle($manga->title);
            if ($malId) {
                // Save MAL ID for future use
                $manga->update(['mal_id' => $malId]);
            }
        }

        // Try to fetch from API
        if ($malId) {
            $coverPath = $this->fetchCoverFromApi($manga, $malId, $minSizeBytes);
            if ($coverPath) {
                $fullPath = storage_path('app/public/' . $coverPath);
                $fileSize = file_exists($fullPath) ? filesize($fullPath) : 0;
                
                // Log if quality is poor
                if ($fileSize > 0 && $fileSize < 10 * 1024) {
                    \Log::warning("Poor quality cover for {$manga->title}: {$fileSize} bytes");
                }
                
                $manga->update(['cover_image' => $coverPath]);
                return 'downloaded';
            }
        }

        // Fallback: Generate placeholder
        $coverPath = $this->generatePlaceholderCover($manga);
        if ($coverPath) {
            $manga->update(['cover_image' => $coverPath]);
            return 'placeholder';
        }

        return 'failed';
    }

    /**
     * Find MAL ID by searching for manga title.
     */
    private function findMalIdByTitle(string $title): ?int
    {
        try {
            $results = $this->apiService->searchManga($title, 1);
            if (!empty($results) && isset($results[0]['mal_id'])) {
                return $results[0]['mal_id'];
            }
        } catch (\Exception $e) {
            \Log::warning("Failed to search for MAL ID: {$title} - " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch cover image from Jikan API with quality checks.
     */
    private function fetchCoverFromApi(Manga $manga, int $malId, int $minSizeBytes = 0): ?string
    {
        try {
            $apiData = $this->apiService->getMangaById($malId);

            if (!$apiData || !isset($apiData['images']['jpg'])) {
                return null;
            }

            // Try different image sizes in order of preference
            $imageUrls = [];
            
            // Prefer large_image_url, then image_url, then small_image_url
            if (isset($apiData['images']['jpg']['large_image_url'])) {
                $imageUrls[] = $apiData['images']['jpg']['large_image_url'];
            }
            if (isset($apiData['images']['jpg']['image_url'])) {
                $imageUrls[] = $apiData['images']['jpg']['image_url'];
            }
            if (isset($apiData['images']['jpg']['small_image_url'])) {
                $imageUrls[] = $apiData['images']['jpg']['small_image_url'];
            }

            if (empty($imageUrls)) {
                return null;
            }

            // Try each URL until we get a good quality image
            foreach ($imageUrls as $imageUrl) {
                $coverPath = $this->apiService->downloadCoverImage($imageUrl, $manga->slug);
                
                if (!$coverPath) {
                    continue;
                }

                $fullPath = storage_path('app/public/' . $coverPath);
                
                // Check file size if minimum specified
                if ($minSizeBytes > 0 && file_exists($fullPath)) {
                    $fileSize = filesize($fullPath);
                    if ($fileSize < $minSizeBytes) {
                        // Delete small file and try next URL
                        @unlink($fullPath);
                        \Log::warning("Cover too small for {$manga->title}: {$fileSize} bytes, trying alternative URL");
                        continue;
                    }
                }

                // If we have a good quality image, return it
                if (file_exists($fullPath) && filesize($fullPath) > 0) {
                    return $coverPath;
                }
            }

            // Try alternative APIs as fallback
            return $this->fetchFromAlternativeApi($manga, $malId, $minSizeBytes);
        } catch (\Exception $e) {
            \Log::error("Failed to fetch cover for {$manga->title} (MAL ID: {$malId}): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Try fetching from alternative APIs (MangaDex, Kitsu).
     */
    private function fetchFromAlternativeApi(Manga $manga, int $malId, int $minSizeBytes = 0): ?string
    {
        // Try MangaDex API
        try {
            $mangadexUrl = $this->fetchFromMangaDex($manga->title);
            if ($mangadexUrl) {
                $coverPath = $this->apiService->downloadCoverImage($mangadexUrl, $manga->slug);
                if ($coverPath) {
                    $fullPath = storage_path('app/public/' . $coverPath);
                    if (file_exists($fullPath) && ($minSizeBytes == 0 || filesize($fullPath) >= $minSizeBytes)) {
                        return $coverPath;
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::debug("MangaDex API failed for {$manga->title}: " . $e->getMessage());
        }

        // Try Kitsu API
        try {
            $kitsuUrl = $this->fetchFromKitsu($manga->title);
            if ($kitsuUrl) {
                $coverPath = $this->apiService->downloadCoverImage($kitsuUrl, $manga->slug);
                if ($coverPath) {
                    $fullPath = storage_path('app/public/' . $coverPath);
                    if (file_exists($fullPath) && ($minSizeBytes == 0 || filesize($fullPath) >= $minSizeBytes)) {
                        return $coverPath;
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::debug("Kitsu API failed for {$manga->title}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch cover from MangaDex API.
     */
    private function fetchFromMangaDex(string $title): ?string
    {
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->get('https://api.mangadex.org/manga', [
                    'title' => $title,
                    'limit' => 1,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['data'][0]['relationships'])) {
                    foreach ($data['data'][0]['relationships'] as $rel) {
                        if ($rel['type'] === 'cover_art' && isset($rel['attributes']['fileName'])) {
                            $mangaId = $data['data'][0]['id'];
                            $fileName = $rel['attributes']['fileName'];
                            return "https://uploads.mangadex.org/covers/{$mangaId}/{$fileName}";
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Silent fail
        }

        return null;
    }

    /**
     * Fetch cover from Kitsu API.
     */
    private function fetchFromKitsu(string $title): ?string
    {
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->get('https://kitsu.io/api/edge/manga', [
                    'filter[text]' => $title,
                    'page[limit]' => 1,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['data'][0]['attributes']['posterImage']['original'])) {
                    return $data['data'][0]['attributes']['posterImage']['original'];
                }
            }
        } catch (\Exception $e) {
            // Silent fail
        }

        return null;
    }

    /**
     * Generate a placeholder cover image.
     */
    private function generatePlaceholderCover(Manga $manga): ?string
    {
        try {
            // Determine colors based on genre
            $genre = strtolower($manga->genre ?? 'default');
            $colors = $this->genreColors['default'];
            
            foreach ($this->genreColors as $key => $value) {
                if (str_contains($genre, $key)) {
                    $colors = $value;
                    break;
                }
            }

            // Create image using GD
            $width = 300;
            $height = 400;
            $image = imagecreatetruecolor($width, $height);

            // Create gradient background
            $color1 = $this->hexToRgb($colors[0]);
            $color2 = $this->hexToRgb($colors[1]);

            for ($y = 0; $y < $height; $y++) {
                $ratio = $y / $height;
                $r = (int) ($color1['r'] + ($color2['r'] - $color1['r']) * $ratio);
                $g = (int) ($color1['g'] + ($color2['g'] - $color1['g']) * $ratio);
                $b = (int) ($color1['b'] + ($color2['b'] - $color1['b']) * $ratio);
                $color = imagecolorallocate($image, $r, $g, $b);
                imageline($image, 0, $y, $width, $y, $color);
            }

            // Add text (first letter of title)
            $firstLetter = strtoupper(substr($manga->title, 0, 1));
            $textColor = imagecolorallocate($image, 255, 255, 255);
            
            // Try to use TTF font, fallback to built-in font
            $fontPath = $this->getFontPath();
            if ($fontPath && function_exists('imagettftext')) {
                $fontSize = 120;
                $bbox = imagettfbbox($fontSize, 0, $fontPath, $firstLetter);
                $textWidth = $bbox[4] - $bbox[0];
                $textHeight = $bbox[1] - $bbox[7];
                $x = ($width - $textWidth) / 2;
                $y = ($height - $textHeight) / 2 + $textHeight;
                imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $firstLetter);
            } else {
                // Fallback: use built-in font (5 = large font)
                $fontSize = 5;
                $textWidth = imagefontwidth($fontSize) * strlen($firstLetter);
                $textHeight = imagefontheight($fontSize);
                $x = ($width - $textWidth) / 2;
                $y = ($height - $textHeight) / 2;
                imagestring($image, $fontSize, $x, $y, $firstLetter, $textColor);
            }

            // Save image
            $filename = "{$manga->slug}-placeholder.jpg";
            $path = "manga-covers/{$filename}";
            $fullPath = storage_path("app/public/{$path}");

            // Ensure directory exists
            Storage::disk('public')->makeDirectory('manga-covers');

            imagejpeg($image, $fullPath, 90);
            imagedestroy($image);

            return $path;
        } catch (\Exception $e) {
            \Log::error("Failed to generate placeholder for {$manga->title}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Convert hex color to RGB array.
     */
    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

    /**
     * Get font path for text rendering.
     */
    private function getFontPath(): string
    {
        // Try to find a system font
        $fonts = [
            '/System/Library/Fonts/Helvetica.ttc',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
        ];

        foreach ($fonts as $font) {
            if (file_exists($font)) {
                return $font;
            }
        }

        // Fallback: use built-in font (but it won't work with imagettftext)
        // We'll use imagestring instead if no font found
        return '';
    }

    /**
     * Download cover from manual URL.
     */
    private function downloadManualCover(Manga $manga, string $url, int $minSizeBytes = 0): ?string
    {
        try {
            $coverPath = $this->apiService->downloadCoverImage($url, $manga->slug);
            if ($coverPath) {
                $fullPath = storage_path('app/public/' . $coverPath);
                if (file_exists($fullPath)) {
                    $fileSize = filesize($fullPath);
                    if ($minSizeBytes > 0 && $fileSize < $minSizeBytes) {
                        @unlink($fullPath);
                        return null;
                    }
                    return $coverPath;
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to download manual cover for {$manga->title}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Display summary statistics.
     */
    private function displaySummary(array $stats): void
    {
        $this->info('📊 Summary:');
        $this->table(
            ['Status', 'Count'],
            [
                ['✅ Downloaded', $stats['downloaded']],
                ['⏭️  Skipped', $stats['skipped']],
                ['🎨 Placeholder Generated', $stats['placeholder']],
                ['❌ Failed', $stats['failed']],
            ]
        );
    }
}

