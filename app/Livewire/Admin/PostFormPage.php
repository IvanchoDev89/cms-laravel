<?php

use App\Livewire\Admin\PostForm;
use Livewire\Volt\Component;

class PostFormPage extends Component
{
    public function mount()
    {
        // Forward to the actual PostForm component
        return $this->redirect(PostForm::class);
    }
}
