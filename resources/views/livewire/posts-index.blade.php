<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Post;

class PostsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $sortBy = 'created_at';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
    ];

    public function render(): \Illuminate\Contracts\View\View
    {
        $query = Post::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->with(['author', 'media', 'taxonomies']);

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

        $posts = $query->paginate(10);

        return view('livewire.admin.posts.posts-index-view-working', [
            'posts' => $posts,
        ]);
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        
        session()->flash('message', 'Post deleted successfully!');
    }
}
