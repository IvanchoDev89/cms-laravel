<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Taxonomy;
use Illuminate\Http\Request;

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
