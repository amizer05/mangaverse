<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->when($request->user()?->id === $this->id || $request->user()?->isAdmin(), $this->email),
            'profile_photo_path' => $this->profile_photo_path ? asset('storage/' . $this->profile_photo_path) : null,
            'birthday' => $this->birthday?->format('Y-m-d'),
            'about_me' => $this->about_me,
            'is_admin' => $this->when($request->user()?->isAdmin(), $this->is_admin),
            'favorites_count' => $this->whenCounted('favorites', $this->favorites()->count()),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}






