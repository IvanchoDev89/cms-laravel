<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::where('status', 'published')
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->category, fn ($q) => $q->whereHas('taxonomies', fn ($t) => $t->where('slug', $request->category)))
            ->with(['author', 'taxonomies'])
            ->latest('published_at')
            ->paginate($request->per_page ?? 15);
        
        return response()->json($posts);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['author', 'taxonomies', 'media'])
            ->firstOrFail();
        
        $post->increment('view_count');
        return response()->json($post);
    }
}
