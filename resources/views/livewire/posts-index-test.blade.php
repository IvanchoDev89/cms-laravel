<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Post;

new class extends Component {
    use WithPagination;

    public function render(): \Illuminate\Contracts\View\View
    {
        $posts = Post::with('author')->latest()->paginate(10);
        
        return view('livewire.admin.posts.posts-index-view-working', [
            'posts' => $posts,
        ]);
    }
};
