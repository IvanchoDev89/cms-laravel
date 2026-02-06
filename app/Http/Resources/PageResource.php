<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image_path' => $this->featured_image_path,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
                'email' => $this->author->email,
            ],
            'media' => $this->media->map(fn ($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'path' => $m->path,
                'mime_type' => $m->mime_type,
                'url' => asset('storage/'.$m->path),
            ]),
            'seo' => [
                'meta_title' => $this->meta_title ?? $this->title,
                'meta_description' => $this->meta_description,
                'meta_keywords' => $this->meta_keywords,
                'og_image' => $this->og_image,
            ],
        ];
    }
}
