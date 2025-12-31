<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GeneratePlaceholderImages extends Command
{
    protected $signature = 'manga:generate-placeholders';
    protected $description = 'Generate placeholder images for manga covers and chapter pages';

    public function handle()
    {
        $this->info('Generating placeholder images...');

        // Create directories
        Storage::disk('public')->makeDirectory('manga-covers');
        Storage::disk('public')->makeDirectory('chapters');

        // Generate placeholder cover images
        $this->generatePlaceholderCover(); // generic

        // Generate simple named covers for demo mangas
        $this->generateNamedCover('one-piece');
        $this->generateNamedCover('naruto');
        $this->generateNamedCover('attack-on-titan');
        $this->generateNamedCover('demon-slayer');
        $this->generateNamedCover('my-hero-academia');
        $this->generateNamedCover('death-note');
        $this->generateNamedCover('jujutsu-kaisen');
        $this->generateNamedCover('chainsaw-man');
        $this->generateNamedCover('spy-x-family');
        $this->generateNamedCover('one-punch-man');
        $this->generateNamedCover('dragon-ball-z');
        $this->generateNamedCover('bleach');

        // Generate placeholder chapter page
        $this->generatePlaceholderPage();

        $this->info('Placeholder images generated successfully!');
        return 0;
    }

    private function generatePlaceholderCover()
    {
        // Create a simple placeholder cover (300x400px)
        $width = 300;
        $height = 400;

        $image = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($image, 30, 41, 59); // slate-800
        $textColor = imagecolorallocate($image, 148, 163, 184); // slate-400

        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
        
        // Add text
        $text = 'MANGA';
        $fontSize = 5;
        $textX = ($width - strlen($text) * imagefontwidth($fontSize)) / 2;
        $textY = ($height - imagefontheight($fontSize)) / 2;
        imagestring($image, $fontSize, $textX, $textY, $text, $textColor);

        $path = storage_path('app/public/manga-covers/placeholder.jpg');
        imagejpeg($image, $path, 80);
        imagedestroy($image);

        $this->info('Generated placeholder cover image');
    }

    /**
     * Generate a simple named cover for a specific manga slug.
     */
    private function generateNamedCover(string $slug): void
    {
        $width = 300;
        $height = 400;

        $image = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($image, 30, 41, 59); // slate-800
        $accentColor = imagecolorallocate($image, 129, 140, 248); // indigo-400
        $textColor = imagecolorallocate($image, 248, 250, 252); // slate-50

        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

        // Simple accent stripe
        imagefilledrectangle($image, 0, 0, $width, 40, $accentColor);

        // Add short slug text in the middle (just visual)
        $text = strtoupper(str_replace('-', ' ', $slug));
        $fontSize = 3;
        $textX = 20;
        $textY = (int) ($height / 2);
        imagestring($image, $fontSize, $textX, $textY, $text, $textColor);

        $path = storage_path("app/public/manga-covers/{$slug}.jpg");
        imagejpeg($image, $path, 80);
        imagedestroy($image);

        $this->info("Generated cover image for {$slug}");
    }

    private function generatePlaceholderPage()
    {
        // Create a simple placeholder page (800x1200px)
        $width = 800;
        $height = 1200;

        $image = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($image, 241, 245, 249); // slate-100
        $textColor = imagecolorallocate($image, 148, 163, 184); // slate-400

        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
        
        // Add text
        $text = 'PAGE';
        $fontSize = 5;
        $textX = ($width - strlen($text) * imagefontwidth($fontSize)) / 2;
        $textY = ($height - imagefontheight($fontSize)) / 2;
        imagestring($image, $fontSize, $textX, $textY, $text, $textColor);

        $path = storage_path('app/public/chapters/placeholder-1.jpg');
        imagejpeg($image, $path, 80);
        imagedestroy($image);

        $this->info('Generated placeholder page image');
    }
}
