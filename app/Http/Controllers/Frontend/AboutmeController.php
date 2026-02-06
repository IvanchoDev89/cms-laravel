<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutmeController extends Controller
{
    /**
     * Display a listing of public profiles.
     */
    public function index(Request $request): View
    {
        $profiles = User::where('show_profile_publicly', true)
            ->whereNotNull('bio')
            ->with('roles')
            ->orderBy('name')
            ->paginate(12);

        return view('frontend.aboutme.index', compact('profiles'));
    }

    /**
     * Display the specified public profile.
     */
    public function show(string $id): View
    {
        $user = User::where('show_profile_publicly', true)
            ->with('roles')
            ->findOrFail($id);

        return view('frontend.aboutme.show', compact('user'));
    }
}
