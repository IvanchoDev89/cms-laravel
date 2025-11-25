<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pages = Page::when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->with('author')
            ->latest()
            ->paginate($request->per_page ?? 20);
        
        return response()->json($pages);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->with(['author', 'media'])
            ->firstOrFail();
        
        return response()->json($page);
    }
}
