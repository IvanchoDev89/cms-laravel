<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Taxonomy;
use Livewire\Component;
use Livewire\WithPagination;

class PostsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $perPage = 10;

    public function mount()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('posts.view')) {
            abort(403, 'Unauthorized');
        }
    }

    public function deletePage($id)
    {
        Post::findOrFail($id)->delete();
        session()->flash('message', 'Post deleted successfully');
    }

    public function getPostsProperty()
    {
        return Post::when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.posts.index', [
            'posts' => $this->getPostsProperty(),
        ]);
    }
}
