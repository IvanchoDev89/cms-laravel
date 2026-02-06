<?php

use App\Livewire\Admin\PageForm;
use Livewire\Volt\Component;

class PageFormPage extends Component
{
    public function mount()
    {
        return $this->redirect(PageForm::class);
    }
}
