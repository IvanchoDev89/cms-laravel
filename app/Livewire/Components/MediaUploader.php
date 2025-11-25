<?php

namespace App\Livewire\Components;

use App\Models\Media;
use Livewire\Component;
use Livewire\WithFileUploads;

class MediaUploader extends Component
{
    use WithFileUploads;

    public $file;
    public $isUploading = false;
    public $uploadProgress = 0;
    public $uploadedMedia = null;

    public function upload()
    {
        $this->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,svg,webp,mp4,mp3,pdf,doc,docx,zip|max:51200',
        ]);

        $this->isUploading = true;

        try {
            $filename = $this->file->getClientOriginalName();
            $path = $this->file->storeAs('media', $filename, 'public');

            $this->uploadedMedia = Media::create([
                'user_id' => auth()->id(),
                'filename' => $filename,
                'path' => $path,
                'disk' => 'public',
                'mime_type' => $this->file->getMimeType(),
                'size' => $this->file->getSize(),
                'meta' => ['uploaded_from' => 'livewire'],
            ]);

            $this->dispatch('media-uploaded', media: $this->uploadedMedia->id);
            $this->file = null;
        } catch (\Exception $e) {
            $this->addError('file', 'Error uploading file: ' . $e->getMessage());
        }

        $this->isUploading = false;
    }

    public function render()
    {
        return view('livewire.components.media-uploader');
    }
}
