@extends('layouts.app')

@section('title', 'Home - Modern CMS')
@section('description', 'Welcome to our modern content management system')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-950 dark:to-gray-900 flex items-center">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-10"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-10"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    Manage Your Content with <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Ease</span>
                </h1>
                <p class="text-xl text-gray-700 dark:text-gray-300 mb-8 leading-relaxed">
                    A modern, powerful, and user-friendly CMS built with Laravel. Create, manage, and publish content with confidence.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('posts.index') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:scale-105 transition inline-block text-center">
                        Read Our Blog
                    </a>
                    @if(!auth()->check())
                        <a href="/login" class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg font-semibold hover:shadow-lg transition inline-block text-center border border-gray-200 dark:border-gray-700">
                            Admin Login
                        </a>
                    @else
                        <a href="/admin/posts" class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg font-semibold hover:shadow-lg transition inline-block text-center border border-gray-200 dark:border-gray-700">
                            Go to Dashboard
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Image/Graphic -->
            <div class="hidden lg:flex justify-center">
                <div class="relative w-full h-96">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-purple-500 rounded-3xl transform rotate-3 opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-purple-400 to-blue-500 rounded-3xl transform -rotate-3 opacity-20"></div>
                    <div class="relative h-full bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 flex flex-col items-center justify-center">
                        <svg class="w-20 h-20 text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-center text-gray-600 dark:text-gray-300">
                            <span class="text-2xl font-bold text-blue-600">100+</span><br/>
                            Content Pieces
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="about" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Powerful Features</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400">Everything you need to manage content efficiently</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-700 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Easy to Use</h3>
                <p class="text-gray-700 dark:text-gray-300">Intuitive interface that requires no technical knowledge to manage your content.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-gray-800 dark:to-gray-700 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Media Manager</h3>
                <p class="text-gray-700 dark:text-gray-300">Upload, organize, and manage all your images, videos, and documents in one place.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-800 dark:to-gray-700 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Fast & Responsive</h3>
                <p class="text-gray-700 dark:text-gray-300">Built with modern technology for lightning-fast performance on all devices.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-gray-800 dark:to-gray-700 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Secure</h3>
                <p class="text-gray-700 dark:text-gray-300">Your data is protected with industry-standard security measures and encryption.</p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-gray-800 dark:to-gray-700 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">REST API</h3>
                <p class="text-gray-700 dark:text-gray-300">Powerful API to integrate your content with external applications and services.</p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-gray-800 dark:to-gray-700 p-8 rounded-xl hover:shadow-lg transition">
                <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">SEO Friendly</h3>
                <p class="text-gray-700 dark:text-gray-300">Built-in SEO optimization to help your content rank better in search engines.</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">{{ \App\Models\Post::where('status', 'published')->count() }}+</div>
                <p>Published Posts</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ \App\Models\User::count() }}</div>
                <p>Active Users</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ \App\Models\Taxonomy::count() }}+</div>
                <p>Categories & Tags</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ \App\Models\Media::count() }}</div>
                <p>Media Files</p>
            </div>
        </div>
    </div>
</section>

<!-- Latest Posts Preview -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Latest Articles</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400">Stay updated with our newest content</p>
        </div>

        @php
            $latestPosts = \App\Models\Post::where('status', 'published')->latest('published_at')->take(3)->get();
        @endphp

        @if($latestPosts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                @foreach($latestPosts as $post)
                    <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transform hover:-translate-y-1 transition">
                        @if($post->media->first())
                            <img src="{{ Storage::url($post->media->first()->path) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                <span class="text-white text-5xl">📝</span>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex gap-2 mb-3">
                                @foreach($post->taxonomies->take(2) as $tax)
                                    <span class="text-xs px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full">{{ $tax->name }}</span>
                                @endforeach
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600 transition">{{ $post->title }}</a>
                            </h3>
                            
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 80) }}</p>
                            
                            <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-500 mb-4">
                                <span>{{ $post->author?->name ?? 'Admin' }}</span>
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                            
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-semibold text-sm">
                                Read Article →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('posts.index') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:scale-105 transition">
                    View All Articles
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 dark:text-gray-400 text-lg">No posts published yet. Come back soon!</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section id="contact" class="py-20 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">Ready to Get Started?</h2>
        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
            Start publishing amazing content today with our powerful CMS platform.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('posts.index') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                Explore Blog
            </a>
            @if(!auth()->check())
                <a href="/login" class="px-8 py-4 bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg font-semibold hover:shadow-lg transition">
                    Start Publishing
                </a>
            @endif
        </div>
    </div>
</section>

@endsection
