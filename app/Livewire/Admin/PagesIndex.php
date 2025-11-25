<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

class PagesIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function mount()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('pages.view')) {
            abort(403, 'Unauthorized');
        }
    }

    public function deletePage($id)
    {
        Page::findOrFail($id)->delete();
        session()->flash('message', 'Page deleted successfully');
    }

    public function getPagesProperty()
    {
        return Page::when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.pages.index', [
            'pages' => $this->getPagesProperty(),
        ]);
    }
}
