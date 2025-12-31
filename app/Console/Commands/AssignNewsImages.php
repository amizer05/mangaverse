<?php

namespace App\Console\Commands;

use App\Services\NewsImageService;
use Illuminate\Console\Command;

class AssignNewsImages extends Command
{
    protected $signature = 'news:assign-images {--all : Assign images to all news items}';
    protected $description = 'Assign relevant manga images to news items based on content';

    public function handle(NewsImageService $service)
    {
        $this->info('Assigning relevant manga images to news items...');

        if ($this->option('all')) {
            // Clear existing images first
            \App\Models\News::whereNotNull('image')->update(['image' => null]);
        }

        $results = $service->assignImagesToAllNews();

        $this->info("✓ Assigned images to {$results['assigned']} news items");
        
        if ($results['failed'] > 0) {
            $this->warn("⊘ Could not assign images to {$results['failed']} news items");
        }

        return 0;
    }
}
