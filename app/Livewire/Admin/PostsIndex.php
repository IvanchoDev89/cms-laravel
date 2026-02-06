<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostsIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $status = '';

    public $sortBy = 'created_at';

    public $perPage = 10;

    public function mount()
    {
        // Temporarily disabled for testing
    }

    public function deletePost($id)
    {
        Post::findOrFail($id)->delete();
        session()->flash('message', 'Post deleted successfully');
    }

    public function getPostsProperty()
    {
        $query = Post::when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($q) => $q->where('status', $this->status));

        // Handle sorting
        switch ($this->sortBy) {
            case 'created_at':
                $query->latest();
                break;
            case 'created_at_desc':
                $query->oldest();
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.posts.posts-index-view-minimal');
    }
}
