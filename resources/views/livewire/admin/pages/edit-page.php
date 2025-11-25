<?php

use Livewire\Volt\Component;

new class extends Component {
    public $pageId;

    public function mount($id)
    {
        $this->pageId = $id;
    }

    public function render()
    {
        return view('livewire.admin.pages.edit-page');
    }
};
