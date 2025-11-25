<?php

namespace App\Http\Controllers\Api;

use App\Models\Taxonomy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaxonomyController extends Controller
{
    public function index(Request $request)
    {
        $taxonomies = Taxonomy::when($request->type, fn ($q) => $q->where('type', $request->type))
            ->with('posts')
            ->get();
        
        return response()->json($taxonomies);
    }

    public function show($slug)
    {
        $taxonomy = Taxonomy::where('slug', $slug)
            ->with('posts')
            ->firstOrFail();
        
        return response()->json($taxonomy);
    }
}
