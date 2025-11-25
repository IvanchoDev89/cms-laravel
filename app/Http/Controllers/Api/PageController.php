<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Http\Resources\PageResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Get paginated list of pages with optional filtering
     * 
     * Query parameters:
     * - search: Search pages by title or content
     * - per_page: Items per page (default: 20, max: 100)
     */
    public function index(Request $request)
    {
        $per_page = min($request->per_page ?? 20, 100);
        
        $pages = Page::when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('content', 'like', "%{$request->search}%"))
            ->with(['author', 'media'])
            ->latest()
            ->paginate($per_page);
        
        return PageResource::collection($pages);
    }

    /**
     * Get a single page by slug
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->with(['author', 'media'])
            ->firstOrFail();
        
        return new PageResource($page);
    }
}
