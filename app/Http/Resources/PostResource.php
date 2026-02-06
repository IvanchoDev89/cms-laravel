<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'status' => $this->status,
            'featured_image_path' => $this->featured_image_path,
            'published_at' => $this->published_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
                'email' => $this->author->email,
            ],
            'taxonomies' => $this->taxonomies->map(fn ($tax) => [
                'id' => $tax->id,
                'name' => $tax->name,
                'slug' => $tax->slug,
                'type' => $tax->type,
            ]),
            'media' => $this->media->map(fn ($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'path' => $m->path,
                'mime_type' => $m->mime_type,
                'url' => asset('storage/' . $m->path),
            ]),
            'views_count' => $this->views_count ?? 0,
            'seo' => [
                'meta_title' => $this->meta_title ?? $this->title,
                'meta_description' => $this->meta_description,
                'meta_keywords' => $this->meta_keywords,
                'og_image' => $this->og_image,
            ],
        ];
    }
}
