<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AboutmeController extends Controller
{
    /**
     * Display a listing of public profiles.
     */
    public function index(Request $request): JsonResponse
    {
        $profiles = User::where('show_profile_publicly', true)
            ->whereNotNull('bio')
            ->with('roles')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'data' => $profiles->map(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'title' => $user->title,
                'location' => $user->location,
                'bio' => $user->bio,
                'profile_image_url' => $user->getProfileImageUrl(),
                'skills' => $user->skills,
                'website' => $user->website,
                'roles' => $user->roles->pluck('name'),
            ]),
            'meta' => [
                'current_page' => $profiles->currentPage(),
                'last_page' => $profiles->lastPage(),
                'per_page' => $profiles->perPage(),
                'total' => $profiles->total(),
            ],
        ]);
    }

    /**
     * Display the specified public profile.
     */
    public function show(string $id): JsonResponse
    {
        $user = User::where('show_profile_publicly', true)
            ->with('roles')
            ->findOrFail($id);

        return response()->json([
            'data' => array_merge($user->getPublicProfile(), [
                'id' => $user->id,
                'profile_image_url' => $user->getProfileImageUrl(),
                'roles' => $user->roles->pluck('name'),
                'created_at' => $user->created_at,
            ]),
        ]);
    }
}
