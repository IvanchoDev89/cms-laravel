<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::with(['author', 'media', 'taxonomies'])
                ->latest()
                ->paginate(10);
                
            return view('admin.posts.posts-standalone', compact('posts'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }
    
    public function test()
    {
        return view('admin.posts.posts-standalone');
    }
}
