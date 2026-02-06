<?php

namespace App\Livewire\Admin;

use App\Models\Media;
use App\Rules\SecureFileUpload;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MediaManager extends Component
{
    use WithFileUploads, WithPagination;

    public $file;

    public $search = '';

    public $perPage = 20;

    public $selectedMedia = [];

    public $showUploadModal = false;

    public $showDeleteModal = false;

    public $mediaToDelete = null;

    protected $paginationTheme = 'bootstrap';

    protected function rules(): array
    {
        return [
            'file' => ['required', 'file', new SecureFileUpload],
        ];
    }

    public function uploadFile()
    {
        $this->validate();

        $path = $this->file->store('media', 'public');

        Media::create([
            'name' => $this->file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $this->file->getMimeType(),
            'size' => $this->file->getSize(),
            'mediable_id' => auth()->id(),
            'mediable_type' => 'App\Models\User',
        ]);

        $this->file = null;
        $this->showUploadModal = false;

        session()->flash('message', 'File uploaded successfully!');
    }

    public function deleteMedia($id)
    {
        $this->mediaToDelete = Media::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if ($this->mediaToDelete) {
            // Delete file from storage
            \Storage::disk('public')->delete($this->mediaToDelete->path);

            // Delete database record
            $this->mediaToDelete->delete();

            $this->mediaToDelete = null;
            $this->showDeleteModal = false;

            session()->flash('message', 'File deleted successfully!');
        }
    }

    public function bulkDelete()
    {
        if (! empty($this->selectedMedia)) {
            $mediaItems = Media::whereIn('id', $this->selectedMedia)->get();

            foreach ($mediaItems as $media) {
                \Storage::disk('public')->delete($media->path);
                $media->delete();
            }

            $this->selectedMedia = [];
            session()->flash('message', 'Selected files deleted successfully!');
        }
    }

    public function getMediaProperty()
    {
        return Media::when($this->search, fn ($query) => $query->where('name', 'like', "%{$this->search}%")
        )
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.media-manager', [
            'mediaItems' => $this->media,
        ]);
    }
}
