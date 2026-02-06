<?php

use App\Livewire\Admin\UserForm;
use Livewire\Volt\Component;

class UserFormPage extends Component
{
    public function mount()
    {
        return $this->redirect(UserForm::class);
    }
}
