<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'content', 'excerpt', 'meta',
        'featured_image_path', 'meta_title', 'meta_description', 'meta_keywords', 'og_image'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
