<?php

use App\Http\Controllers\Frontend\AboutmeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    // Login Routes
    Route::get('/login', function () {
        return view('livewire.auth.login');
    })->name('login');

    Route::post('/login', function () {
        $credentials = request()->only(['email', 'password']);

        if (auth()->attempt($credentials, request()->boolean('remember'))) {
            request()->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput(request()->only('email'));
    })->name('login.store');

    // Registration Routes
    Route::get('/register', function () {
        return view('livewire.auth.register');
    })->name('register');

    Route::post('/register', function () {
        $validated = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        auth()->login($user);
        request()->session()->regenerate();

        return redirect(route('dashboard'));
    })->name('register.store');

    // Password Reset Routes
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Logout Route - should be accessible to authenticated users
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Frontend Routes - Public
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');

// About Me Routes - Public Profiles
Route::get('/aboutme', [AboutmeController::class, 'index'])->name('aboutme.index');
Route::get('/aboutme/{id}', [AboutmeController::class, 'show'])->name('aboutme.show');

// Wallet Routes
Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
Route::get('/wallet/{wallet}', [WalletController::class, 'show'])->name('wallet.show');
Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');
Route::get('/wallet/earnings', [WalletController::class, 'earningsReport'])->name('wallet.earnings');
Route::get('/admin/wallet', [WalletController::class, 'adminDashboard'])->name('wallet.admin');
Route::get('/admin/commission-settings', [WalletController::class, 'commissionSettings'])->name('wallet.commission-settings');
Route::post('/admin/commission-settings', [WalletController::class, 'updateCommissionSettings'])->name('wallet.commission-settings.update');

// Subscription Routes
Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
Route::get('/subscriptions/{plan}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
Route::post('/subscriptions/{plan}/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
Route::post('/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');

// Payment Routes
Route::get('/payments/{payment}/process/{gateway}', [PaymentController::class, 'process'])->name('payments.process');
Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');
Route::get('/payments/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');
Route::post('/webhooks/{gateway}', [PaymentController::class, 'webhook'])->name('payments.webhook');

// Message Routes
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');

Route::get('/dashboard', function () {
    return view('dashboard-analytics');
})
    ->middleware(['auth'])
    ->name('dashboard');

// Test routes outside auth middleware
Route::get('test-simple', function () {
    return 'Simple test route working';
});

Route::get('admin/posts-debug', [\App\Http\Controllers\Admin\PostsController::class, 'index'])->name('admin.posts.debug');
Route::get('admin/posts-test-view', [\App\Http\Controllers\Admin\PostsController::class, 'test'])->name('admin.posts.test.view');

Route::middleware(['auth', 'throttle:30,1'])->group(function () {
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

    // CMS Routes - Enhanced with rate limiting
    Route::middleware('throttle:60,1')->group(function () {
        Route::view('admin/dashboard', 'dashboard-enhanced')->name('admin.dashboard');
        Route::view('admin/settings', 'dashboard')->name('admin.settings.index');
        Route::view('admin/test', 'dashboard-test')->name('admin.test');
        Route::view('test-posts-view', 'test-posts-view')->name('test.posts.view');
        Route::get('admin/media', \App\Livewire\Admin\MediaManager::class)->name('admin.media.index');
        Route::get('admin/posts', [\App\Http\Controllers\Admin\PostsController::class, 'index'])->name('admin.posts.index');
        Route::get('admin/posts-test-simple', [\App\Http\Controllers\Admin\PostsController::class, 'index'])->name('admin.posts.test.simple');
        // Temporarily disable Volt routes that have missing components
        // Volt::route('admin/posts-test', 'posts-index-test')->name('admin.posts.test');
        // Volt::route('admin/posts/create', 'post-form-page')->name('admin.posts.create');
        // Volt::route('admin/posts/{id}/edit', 'post-form-page')->name('admin.posts.edit');
        // Volt::route('admin/pages', 'pages-index')->name('admin.pages.index');
        // Volt::route('admin/pages/create', 'page-form-page')->name('admin.pages.create');
        // Volt::route('admin/pages/{id}/edit', 'page-form-page')->name('admin.pages.edit');
        // Volt::route('admin/users', 'users-index')->name('admin.users.index');
        // Volt::route('admin/users/create', 'user-form-page')->name('admin.users.create');
        // Volt::route('admin/users/{id}/edit', 'user-form-page')->name('admin.users.edit');
    });
});
