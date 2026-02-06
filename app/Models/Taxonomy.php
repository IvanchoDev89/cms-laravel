<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'type', 'description', 'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_taxonomy');
    }
}
