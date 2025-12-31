<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
            'chapter_number' => $this->chapter_number,
            'title' => $this->title,
            'language' => $this->language,
            'page_count' => $this->page_count,
            'views' => $this->views,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'pages' => ChapterPageResource::collection($this->whenLoaded('pages')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}






