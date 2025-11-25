<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Str;

class PageForm extends Component
{
    public $pageId = null;
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';

    protected $rules = [
        'title' => 'required|min:3',
        'slug' => 'required|unique:pages,slug',
        'content' => 'nullable|min:5',
    ];

    public function mount($pageId = null)
    {
        if (!auth()->check() || !auth()->user()->hasPermission('posts.create')) {
            if (!($pageId && auth()->user()?->hasPermission('posts.edit'))) {
                abort(403, 'Unauthorized');
            }
        }
        if ($pageId) {
            $page = Page::findOrFail($pageId);
            $this->pageId = $page->id;
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->excerpt = $page->excerpt;
            $this->content = $page->content;
        }
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
        ];

        if ($this->pageId) {
            Page::findOrFail($this->pageId)->update($data);
            session()->flash('message', 'Page updated successfully');
        } else {
            $page = Page::create($data);
            session()->flash('message', 'Page created successfully');
            $this->redirect(route('pages.edit', $page->id));
        }
    }

    public function render()
    {
        return view('livewire.admin.pages.form');
    }
}
