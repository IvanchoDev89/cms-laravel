<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PageController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Frontend Routes - Public
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    // CMS Routes
    Volt::route('admin/media', 'livewire.pages.media')->name('admin.media.index');
    Volt::route('admin/posts', 'livewire.admin.posts.index-page')->name('admin.posts.index');
    Volt::route('admin/posts/create', 'livewire.admin.posts.create-page')->name('admin.posts.create');
    Volt::route('admin/posts/{id}/edit', 'livewire.admin.posts.edit-page')->name('admin.posts.edit');
    Volt::route('admin/pages', 'livewire.admin.pages.index-page')->name('admin.pages.index');
    Volt::route('admin/pages/create', 'livewire.admin.pages.create-page')->name('admin.pages.create');
    Volt::route('admin/pages/{id}/edit', 'livewire.admin.pages.edit-page')->name('admin.pages.edit');

    // User Management Routes
    Volt::route('admin/users', 'livewire.admin.users.index-page')->name('admin.users.index');
    Volt::route('admin/users/create', 'livewire.admin.users.create-page')->name('admin.users.create');
    Volt::route('admin/users/{id}/edit', 'livewire.admin.users.edit-page')->name('admin.users.edit');
});

