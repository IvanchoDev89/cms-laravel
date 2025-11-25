<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::latest()->paginate(20);
        return response()->json($media);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,svg,webp,mp4,mp3,pdf,doc,docx,zip|max:51200'
        ]);

        // Ensure user is authenticated and has upload permission
        $user = $request->user();
        if (!$user || !$user->hasPermission('media.upload')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $file = $request->file('file');
        $disk = config('filesystems.default') ?: 'public';
        $path = $file->store('media', $disk);

        $media = Media::create([
            'user_id' => $user->id,
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'disk' => $disk,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'meta' => ['hash' => Str::random(12)],
        ]);

        return response()->json($media, 201);
    }

    public function show($id)
    {
        $media = Media::findOrFail($id);
        return response()->json($media);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        // Authorization: only owner or user with 'media.delete' permission
        $user = request()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($media->user_id !== $user->id && !$user->hasPermission('media.delete')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // delete file from disk if exists
        try {
            Storage::disk($media->disk)->delete($media->path);
        } catch (\Throwable $e) {
            // ignore
        }
        $media->delete();
        return response()->json(['deleted' => true]);
    }
}
