<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateNewsImages extends Command
{
    protected $signature = 'news:generate-images {--all : Generate images for all news items}';
    protected $description = 'Generate placeholder images for news items that don\'t have images';

    public function handle()
    {
        $newsItems = $this->option('all') 
            ? News::all() 
            : News::whereNull('image')->orWhere('image', '')->get();

        if ($newsItems->isEmpty()) {
            $this->info('No news items need images.');
            return 0;
        }

        $this->info("Generating images for {$newsItems->count()} news items...");

        $bar = $this->output->createProgressBar($newsItems->count());
        $bar->start();

        foreach ($newsItems as $news) {
            try {
                $this->generateNewsImage($news);
                $bar->advance();
            } catch (\Exception $e) {
                $this->newLine();
                $this->warn("Error generating image for '{$news->title}': " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('✓ Images generated successfully!');

        return 0;
    }

    private function generateNewsImage(News $news)
    {
        // Create a 1200x630 image (optimal for social media/news)
        $width = 1200;
        $height = 630;

        $image = imagecreatetruecolor($width, $height);

        // Generate gradient colors based on title hash
        $hash = crc32($news->title);
        $color1 = $this->hashToColor($hash);
        $color2 = $this->hashToColor($hash + 1000);

        // Draw gradient
        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $r = (int)(($color1['r'] * (1 - $ratio)) + ($color2['r'] * $ratio));
            $g = (int)(($color1['g'] * (1 - $ratio)) + ($color2['g'] * $ratio));
            $b = (int)(($color1['b'] * (1 - $ratio)) + ($color2['b'] * $ratio));
            
            $color = imagecolorallocate($image, $r, $g, $b);
            imageline($image, 0, $y, $width, $y, $color);
        }

        // Add dark overlay for better text readability
        $overlay = imagecolorallocatealpha($image, 0, 0, 0, 77); // 30% opacity
        imagefilledrectangle($image, 0, 0, $width, $height, $overlay);

        // Add title text
        $title = $news->title;
        $maxLength = 60;
        if (strlen($title) > $maxLength) {
            $title = substr($title, 0, $maxLength - 3) . '...';
        }

        // Split title into lines if needed
        $words = explode(' ', $title);
        $lines = [];
        $currentLine = '';
        
        foreach ($words as $word) {
            if (strlen($currentLine . ' ' . $word) <= 50) {
                $currentLine .= ($currentLine ? ' ' : '') . $word;
            } else {
                if ($currentLine) $lines[] = $currentLine;
                $currentLine = $word;
            }
        }
        if ($currentLine) $lines[] = $currentLine;

        $textColor = imagecolorallocate($image, 255, 255, 255);
        $fontSize = 5; // GD built-in font
        $lineHeight = 60;
        $yOffset = ($height - (count($lines) * $lineHeight)) / 2;

        foreach ($lines as $index => $line) {
            $textWidth = strlen($line) * imagefontwidth($fontSize);
            $x = ($width - $textWidth) / 2;
            $y = $yOffset + ($index * $lineHeight);
            imagestring($image, $fontSize, $x, $y, $line, $textColor);
        }

        // Add date if available
        if ($news->published_at) {
            $dateText = $news->published_at->format('M d, Y');
            $dateColor = imagecolorallocatealpha($image, 255, 255, 255, 50);
            $dateFontSize = 3;
            $dateWidth = strlen($dateText) * imagefontwidth($dateFontSize);
            $dateX = ($width - $dateWidth) / 2;
            imagestring($image, $dateFontSize, $dateX, $height - 50, $dateText, $dateColor);
        }

        // Save image
        $filename = 'news-' . \Str::slug($news->title) . '-' . $news->id . '.jpg';
        $path = 'news-images/' . $filename;

        $tempPath = sys_get_temp_dir() . '/' . $filename;
        imagejpeg($image, $tempPath, 85);
        Storage::disk('public')->put($path, file_get_contents($tempPath));
        unlink($tempPath);
        imagedestroy($image);

        // Update news item
        $news->update(['image' => $path]);
    }

    private function hashToColor($hash)
    {
        // Generate vibrant colors
        $r = abs($hash % 100) + 100; // 100-200
        $g = abs(($hash * 2) % 100) + 100;
        $b = abs(($hash * 3) % 100) + 100;
        
        return ['r' => $r, 'g' => $g, 'b' => $b];
    }
}
