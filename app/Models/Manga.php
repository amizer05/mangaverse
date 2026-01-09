<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'description',
        'genre',
        'release_date',
        'mal_id',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the chapters for the manga.
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('chapter_number', 'desc');
    }

    /**
     * Get published chapters.
     */
    public function publishedChapters()
    {
        return $this->chapters()->where('is_published', true);
    }

    /**
     * Get total chapter count.
     */
    public function getTotalChaptersAttribute(): int
    {
        return $this->publishedChapters()->count();
    }

    /**
     * Scope for ordering mangas by popularity.
     * Uses chapter count as popularity measure
     */
    public function scopePopular($query)
    {
        // Count published chapters and order by that
        return $query->withCount(['publishedChapters as popularity'])
                     ->orderByDesc('popularity')
                     ->orderByDesc('created_at');
    }
    
    /**
     * Get genres attribute - extract from genre string
     * This is a simple way to get genres as array
     */
    public function getGenresAttribute()
    {
        if (empty($this->genre)) {
            return [];
        }
        // Split by comma or semicolon
        return array_map('trim', preg_split('/[,;]/', $this->genre));
    }

    /**
     * Get the users who favorited this manga.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')
                    ->withTimestamps();
    }

    /**
     * Get the cover image URL with cache busting and fallback.
     * 
     * @return string
     */
    public function getCoverImageUrlAttribute(): string
    {
        if (!$this->cover_image) {
            return asset('images/default-manga-cover.svg');
        }

        $coverPath = storage_path('app/public/' . $this->cover_image);
        
        // Check if file exists
        if (!file_exists($coverPath)) {
            return asset('images/default-manga-cover.svg');
        }

        // Add cache busting with file modification time
        $cacheBuster = filemtime($coverPath);
        
        return asset('storage/' . $this->cover_image) . '?v=' . $cacheBuster;
    }

    /**
     * Check if cover image exists.
     * 
     * @return bool
     */
    public function hasCoverImage(): bool
    {
        if (!$this->cover_image) {
            return false;
        }

        $coverPath = storage_path('app/public/' . $this->cover_image);
        return file_exists($coverPath) && filesize($coverPath) > 0;
    }
}
