<?php

namespace App\Livewire\Components;

use App\Models\Media;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class MediaManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 12;

    #[On('media-uploaded')]
    public function refreshMedia()
    {
        $this->resetPage();
    }

    public function deleteMedia($id)
    {
        $media = Media::findOrFail($id);
        \Illuminate\Support\Facades\Storage::disk($media->disk)->delete($media->path);
        $media->delete();
        $this->dispatch('notify', message: 'Media deleted successfully');
    }

    public function getMediaProperty()
    {
        return Media::when($this->search, fn ($q) => $q->where('filename', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.components.media-manager', [
            'media' => $this->getMediaProperty(),
        ]);
    }
}
