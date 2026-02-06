<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Get paginated list of published posts with optional filtering
     *
     * Query parameters:
     * - search: Search posts by title
     * - category: Filter by category slug
     * - per_page: Items per page (default: 15, max: 100)
     * - page: Page number for pagination
     * - sort: Sort by 'published_at' (default) or 'popular'
     */
    public function index(Request $request)
    {
        $per_page = min($request->per_page ?? 15, 100);

        $posts = Post::where('status', 'published')
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('content', 'like', "%{$request->search}%"))
            ->when($request->category, fn ($q) => $q->whereHas('taxonomies', fn ($t) => $t->where('slug', $request->category)))
            ->with(['author', 'taxonomies', 'media'])
            ->withCount('views')
            ->when($request->sort === 'popular', fn ($q) => $q->orderByDesc('views_count'), fn ($q) => $q->latest('published_at'))
            ->paginate($per_page);

        return PostResource::collection($posts);
    }

    /**
     * Get a single post by slug
     *
     * Records a view in the database
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['author', 'taxonomies', 'media'])
            ->withCount('views')
            ->firstOrFail();

        // Record post view
        try {
            \App\Models\PostView::create([
                'post_id' => $post->id,
                'ip' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            // Ignore view recording errors
        }

        return new PostResource($post);
    }
}
