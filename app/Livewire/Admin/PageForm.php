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
    public $featured_image_path = null;
    public $meta_title = '';
    public $meta_description = '';
    public $meta_keywords = '';
    public $og_image = null;

    protected $rules = [
        'title' => 'required|min:3',
        'slug' => 'required|unique:pages,slug',
        'content' => 'nullable|min:5',
        'meta_title' => 'nullable|max:60',
        'meta_description' => 'nullable|max:160',
        'meta_keywords' => 'nullable|max:255',
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
            $this->featured_image_path = $page->featured_image_path;
            $this->meta_title = $page->meta_title;
            $this->meta_description = $page->meta_description;
            $this->meta_keywords = $page->meta_keywords;
            $this->og_image = $page->og_image;
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
            'featured_image_path' => $this->featured_image_path,
            'meta_title' => $this->meta_title ?: $this->title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'og_image' => $this->og_image,
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
        return view('livewire.admin.pages.form-enhanced');
    }
}
