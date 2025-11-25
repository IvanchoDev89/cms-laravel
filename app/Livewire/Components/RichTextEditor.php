<?php

namespace App\Livewire\Components;

use Livewire\Component;

class RichTextEditor extends Component
{
    public $content = '';

    public function mount($content = '')
    {
        $this->content = $content;
    }

    public function updatedContent($value)
    {
        $this->content = $value;
        $this->dispatch('content-updated', content: $value);
    }

    public function render()
    {
        return view('livewire.components.rich-text-editor');
    }
}
