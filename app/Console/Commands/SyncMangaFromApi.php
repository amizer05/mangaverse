<?php

namespace App\Console\Commands;

use App\Services\MangaApiService;
use App\Models\Manga;
use Illuminate\Console\Command;

class SyncMangaFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manga:sync 
                            {--title= : Search and sync manga by title}
                            {--top : Sync top manga from API}
                            {--limit=20 : Number of top manga to sync}
                            {--update : Update existing manga}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync manga data from Jikan API (MyAnimeList)';

    /**
     * Execute the console command.
     */
    public function handle(MangaApiService $apiService)
    {
        if ($this->option('title')) {
            $this->syncByTitle($apiService, $this->option('title'));
        } elseif ($this->option('top')) {
            $this->syncTopManga($apiService, (int) $this->option('limit'));
        } else {
            $this->error('Please specify --title or --top option');
            return 1;
        }

        return 0;
    }

    /**
     * Sync manga by title.
     */
    private function syncByTitle(MangaApiService $apiService, string $title)
    {
        $this->info("Searching for: {$title}");

        $manga = $apiService->findAndSyncManga($title);

        if ($manga) {
            $this->info("✓ Synced: {$manga->title}");
            $this->info("  Cover: " . ($manga->cover_image ?: 'Not available'));
        } else {
            $this->error("✗ Manga not found: {$title}");
        }
    }

    /**
     * Sync top manga.
     */
    private function syncTopManga(MangaApiService $apiService, int $limit)
    {
        $this->info("Fetching top {$limit} manga from API...");

        $topManga = $apiService->getTopManga($limit);

        if (empty($topManga)) {
            $this->error('No manga found');
            return;
        }

        $this->info("Found " . count($topManga) . " manga. Syncing...");

        $bar = $this->output->createProgressBar(count($topManga));
        $bar->start();

        $synced = 0;
        $skipped = 0;

        foreach ($topManga as $apiData) {
            $title = $apiData['title'] ?? $apiData['title_english'] ?? 'Unknown';
            $slug = \Illuminate\Support\Str::slug($title);

            // Check if manga already exists
            $existingManga = Manga::where('slug', $slug)->first();

            if ($existingManga && !$this->option('update')) {
                $skipped++;
                $bar->advance();
                continue;
            }

            try {
                $malId = $apiData['mal_id'] ?? null;
                if ($malId) {
                    $fullData = $apiService->getMangaById($malId);
                    if ($fullData) {
                        $apiService->syncMangaFromApi($fullData, $existingManga);
                        $synced++;
                    }
                }
            } catch (\Exception $e) {
                $this->newLine();
                $this->warn("Error syncing {$title}: " . $e->getMessage());
            }

            $bar->advance();

            // Rate limiting - Jikan API has rate limits
            usleep(500000); // 0.5 second delay
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✓ Synced: {$synced}");
        $this->info("⊘ Skipped: {$skipped}");
    }
}
