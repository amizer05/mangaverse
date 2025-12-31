<?php

namespace App\Console\Commands;

use App\Models\Chapter;
use App\Models\ChapterPage;
use App\Models\Manga;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateDemoChapters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chapters:generate-demo 
                            {--manga= : Specific manga slug to generate chapters for}
                            {--count=3 : Number of chapters to generate per manga}
                            {--pages=10 : Number of pages per chapter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate demo chapters with placeholder images for manga';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mangaSlug = $this->option('manga');
        $chapterCount = (int) $this->option('count');
        $pagesPerChapter = (int) $this->option('pages');

        if ($mangaSlug) {
            $manga = Manga::where('slug', $mangaSlug)->first();
            if (!$manga) {
                $this->error("Manga with slug '{$mangaSlug}' not found.");
                return 1;
            }
            $mangas = collect([$manga]);
        } else {
            $mangas = Manga::all();
        }

        if ($mangas->isEmpty()) {
            $this->error('No mangas found.');
            return 1;
        }

        $this->info("Generating demo chapters for {$mangas->count()} manga(s)...");
        $this->newLine();

        $totalChapters = 0;
        $totalPages = 0;

        foreach ($mangas as $manga) {
            $this->info("Processing: {$manga->title}");

            // Get existing chapter numbers
            $existingChapters = $manga->chapters()
                ->where('language', 'EN')
                ->pluck('chapter_number')
                ->toArray();

            $startChapter = empty($existingChapters) ? 1 : max($existingChapters) + 1;

            for ($i = 0; $i < $chapterCount; $i++) {
                $chapterNumber = $startChapter + $i;

                // Skip if chapter already exists
                if (in_array($chapterNumber, $existingChapters)) {
                    $this->warn("  Chapter {$chapterNumber} already exists, skipping...");
                    continue;
                }

                $this->line("  Creating Chapter {$chapterNumber}...");

                $chapter = Chapter::create([
                    'manga_id' => $manga->id,
                    'chapter_number' => $chapterNumber,
                    'title' => $this->generateChapterTitle($chapterNumber),
                    'language' => 'EN',
                    'page_count' => $pagesPerChapter,
                    'is_published' => true,
                    'published_at' => now()->subDays($i),
                ]);

                // Generate pages
                for ($pageNum = 1; $pageNum <= $pagesPerChapter; $pageNum++) {
                    $imagePath = $this->generatePageImage($manga, $chapter, $pageNum);
                    
                    ChapterPage::create([
                        'chapter_id' => $chapter->id,
                        'page_number' => $pageNum,
                        'image_path' => $imagePath,
                    ]);
                }

                $totalChapters++;
                $totalPages += $pagesPerChapter;
            }

            $this->newLine();
        }

        $this->info("✓ Generated {$totalChapters} chapters with {$totalPages} total pages!");
        return 0;
    }

    /**
     * Generate a placeholder page image.
     */
    private function generatePageImage(Manga $manga, Chapter $chapter, int $pageNumber): string
    {
        $width = 800;
        $height = 1200;
        
        // Create image
        $image = imagecreatetruecolor($width, $height);
        
        // Colors
        $bgColor = imagecolorallocate($image, 30, 41, 59); // slate-800
        $textColor = imagecolorallocate($image, 148, 163, 184); // slate-400
        $accentColor = imagecolorallocate($image, 99, 102, 241); // indigo-500
        
        // Fill background
        imagefill($image, 0, 0, $bgColor);
        
        // Add gradient effect
        for ($i = 0; $i < $height; $i++) {
            $alpha = (int) (127 * ($i / $height));
            $color = imagecolorallocatealpha($image, 99, 102, 241, $alpha);
            imageline($image, 0, $i, $width, $i, $color);
        }
        
        // Add border
        imagerectangle($image, 5, 5, $width - 6, $height - 6, $accentColor);
        
        // Add text
        $fontSize = 5;
        $text = "{$manga->title}";
        $x = ($width - strlen($text) * imagefontwidth($fontSize)) / 2;
        $y = $height / 2 - 60;
        imagestring($image, $fontSize, $x, $y, $text, $textColor);
        
        $text = "Chapter {$chapter->chapter_number}";
        $x = ($width - strlen($text) * imagefontwidth($fontSize)) / 2;
        $y = $height / 2 - 30;
        imagestring($image, $fontSize, $x, $y, $text, $textColor);
        
        $text = "Page {$pageNumber}";
        $x = ($width - strlen($text) * imagefontwidth($fontSize)) / 2;
        $y = $height / 2;
        imagestring($image, $fontSize, $x, $y, $text, $accentColor);
        
        $text = "Demo Content";
        $x = ($width - strlen($text) * imagefontwidth(3)) / 2;
        $y = $height / 2 + 40;
        imagestring($image, 3, $x, $y, $text, $textColor);
        
        // Save image
        $directory = "chapters/{$manga->slug}/{$chapter->id}";
        Storage::disk('public')->makeDirectory($directory);
        
        $filename = "page_{$pageNumber}.jpg";
        $path = "{$directory}/{$filename}";
        
        imagejpeg($image, storage_path("app/public/{$path}"), 85);
        imagedestroy($image);
        
        return $path;
    }

    /**
     * Generate a chapter title.
     */
    private function generateChapterTitle(int $chapterNumber): string
    {
        $titles = [
            'The Beginning',
            'A New Journey',
            'Unexpected Encounter',
            'The Battle Begins',
            'Revelations',
            'The Truth',
            'New Allies',
            'The Final Stand',
            'Epilogue',
            'New Horizons',
        ];
        
        return $titles[($chapterNumber - 1) % count($titles)] ?? "Chapter {$chapterNumber}";
    }
}






