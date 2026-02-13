<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

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
                'line' => $e->getLine(),
            ]);
        }
    }
<<<<<<< HEAD

=======
    
    public function create()
    {
        return view('admin.posts.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);
        
        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'slug' => \Str::slug($validated['title']),
            'author_id' => auth()->id(),
        ]);
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully!');
    }
    
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);
        
        $post = Post::findOrFail($id);
        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'slug' => \Str::slug($validated['title']),
        ]);
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }
    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }
    
>>>>>>> 6227176 (feat: v1.2.0 - Complete Multi-Tenant CMS with Advanced Features)
    public function test()
    {
        return view('admin.posts.posts-standalone');
    }
}
