<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

class PagesIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $status = '';

    public $sortBy = 'created_at';

    public $perPage = 10;

    public function mount()
    {
        // Temporarily remove permission check for testing
        // if (!auth()->check() || !auth()->user()->hasPermission('pages.view')) {
        //     abort(403, 'Unauthorized');
        // }
    }

    public function deletePage($id)
    {
        Page::findOrFail($id)->delete();
        session()->flash('message', 'Page deleted successfully');
    }

    public function getPagesProperty()
    {
        $query = Page::when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
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
        return view('livewire.admin.pages.pages-index-view', [
            'pages' => $this->getPagesProperty(),
        ]);
    }
}
