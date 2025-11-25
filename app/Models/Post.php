<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content', 'status', 'published_at', 'meta'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'meta' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class, 'post_taxonomy');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }
}
