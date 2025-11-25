<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->with(['author', 'media'])
            ->firstOrFail();
        
        return view('frontend.pages.show', compact('page'));
    }
}
