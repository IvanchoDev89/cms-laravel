<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Taxonomy;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::where('status', 'published')
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->category, fn ($q) => $q->whereHas('taxonomies', fn ($t) => $t->where('slug', $request->category)))
            ->with(['author', 'taxonomies'])
            ->latest('published_at')
            ->paginate(12);

        $categories = Taxonomy::where('type', 'category')->get();

        return view('frontend.posts.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['author', 'taxonomies', 'media'])
            ->firstOrFail();
        // Record view in post_views for analytics
        try {
            \App\Models\PostView::create([
                'post_id' => $post->id,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'user_id' => auth()->id(),
            ]);
        } catch (\Exception $e) {
            // ignore logging errors to avoid breaking frontend
        }
        // Backward-compatible increment if the column exists
        if (\Illuminate\Support\Facades\Schema::hasColumn('posts', 'view_count')) {
            $post->increment('view_count');
        }
        $relatedPosts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('frontend.posts.show', compact('post', 'relatedPosts'));
    }
}
