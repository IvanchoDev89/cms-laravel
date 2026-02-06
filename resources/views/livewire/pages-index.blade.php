<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Page;

class PagesIndex extends Component
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
        $query = Page::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->with('author');

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

        $pages = $query->paginate(10);

        return view('livewire.admin.pages.pages-index-view', [
            'pages' => $pages,
        ]);
    }

    public function deletePage($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        
        session()->flash('message', 'Page deleted successfully!');
    }
}
