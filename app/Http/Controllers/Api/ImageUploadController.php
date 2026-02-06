<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * Handle image upload from Tiptap editor.
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB max
        ]);

        // Check permission
        if (! auth()->user()->hasPermission('media.upload')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $file = $request->file('image');
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();

            // Store file
            $path = $file->storeAs('posts', $filename, 'public');

            // Create media record
            $media = Media::create([
                'user_id' => auth()->id(),
                'filename' => $filename,
                'path' => $path,
                'disk' => 'public',
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'type' => 'image',
            ]);

            return response()->json([
                'success' => true,
                'url' => Storage::disk('public')->url($path),
                'media' => $media,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Upload failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get available images for media picker.
     */
    public function getImages(Request $request): JsonResponse
    {
        $images = Media::where('type', 'image')
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => $images->map(fn ($m) => [
                'id' => $m->id,
                'url' => Storage::disk($m->disk)->url($m->path),
                'filename' => $m->filename,
            ]),
            'pagination' => [
                'total' => $images->total(),
                'per_page' => $images->perPage(),
                'current_page' => $images->currentPage(),
                'last_page' => $images->lastPage(),
            ],
        ]);
    }
}
