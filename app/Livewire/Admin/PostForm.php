<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Taxonomy;
use Illuminate\Support\Str;
use Livewire\Component;

class PostForm extends Component
{
    public $postId = null;

    public $title = '';

    public $slug = '';

    public $excerpt = '';

    public $content = '';

    public $status = 'draft';

    public $selectedTaxonomies = [];

    public $published_at = null;

    public $featured_image_path = null;

    public $meta_title = '';

    public $meta_description = '';

    public $meta_keywords = '';

    public $og_image = null;

    protected $rules = [
        'title' => 'required|min:3',
        'slug' => 'required|unique:posts,slug',
        'content' => 'nullable|min:5',
        'status' => 'required|in:draft,published,archived',
        'meta_title' => 'nullable|max:60',
        'meta_description' => 'nullable|max:160',
        'meta_keywords' => 'nullable|max:255',
    ];

    public function mount($postId = null)
    {
        if (! auth()->check() || ! auth()->user()->hasPermission('posts.create')) {
            // allow viewing for edits if user has edit permission; otherwise block
            if (! ($postId && auth()->user()?->hasPermission('posts.edit'))) {
                abort(403, 'Unauthorized');
            }
        }
        if ($postId) {
            $post = Post::findOrFail($postId);
            $this->postId = $post->id;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->excerpt = $post->excerpt;
            $this->content = $post->content;
            $this->status = $post->status;
            $this->published_at = $post->published_at;
            $this->selectedTaxonomies = $post->taxonomies->pluck('id')->toArray();
            $this->featured_image_path = $post->featured_image_path;
            $this->meta_title = $post->meta_title;
            $this->meta_description = $post->meta_description;
            $this->meta_keywords = $post->meta_keywords;
            $this->og_image = $post->og_image;
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
            'status' => $this->status,
            'published_at' => $this->status === 'published' ? now() : null,
            'featured_image_path' => $this->featured_image_path,
            'meta_title' => $this->meta_title ?: $this->title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'og_image' => $this->og_image,
        ];

        if ($this->postId) {
            Post::findOrFail($this->postId)->update($data);
            if ($this->selectedTaxonomies) {
                Post::findOrFail($this->postId)->taxonomies()->sync($this->selectedTaxonomies);
            }
            session()->flash('message', 'Post updated successfully');
        } else {
            $post = Post::create($data);
            if ($this->selectedTaxonomies) {
                $post->taxonomies()->sync($this->selectedTaxonomies);
            }
            session()->flash('message', 'Post created successfully');
            $this->redirect(route('posts.edit', $post->id));
        }
    }

    public function getTaxonomiesProperty()
    {
        return Taxonomy::all();
    }

    public function render()
    {
        return view('livewire.admin.posts.form-enhanced', [
            'taxonomies' => $this->getTaxonomiesProperty(),
        ]);
    }
}
