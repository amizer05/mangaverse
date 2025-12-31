<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MangaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'genre' => $this->genre,
            'cover_image' => $this->cover_image ? asset('storage/' . $this->cover_image) : null,
            'release_date' => $this->release_date?->format('Y-m-d'),
            'chapters_count' => $this->whenCounted('chapters', $this->chapters()->where('is_published', true)->count()),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}






