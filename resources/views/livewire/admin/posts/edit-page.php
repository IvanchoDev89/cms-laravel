<?php

use Livewire\Volt\Component;

new class extends Component
{
    public $postId;

    public function mount($id)
    {
        $this->postId = $id;
    }

    public function render()
    {
        return view('livewire.admin.posts.edit-page');
    }
};
