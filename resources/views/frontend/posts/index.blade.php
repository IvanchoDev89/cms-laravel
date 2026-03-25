@extends('layouts.app')

@section('title', 'Blog - ' . config('app.name', 'Modern CMS'))
@section('description', 'Discover insights, tutorials, and best practices from our blog')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 dark:from-blue-900 dark:via-indigo-900 dark:to-purple-900">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.03%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight">
                Our Blog
            </h1>
            <p class="mt-6 text-xl text-blue-100 dark:text-blue-200 leading-relaxed">
                Discover insights, tutorials, and best practices to help you build amazing things.
            </p>
            
            <!-- Search -->
            <div class="mt-10 max-w-xl mx-auto">
                <form action="{{ route('posts.index') }}" method="GET" class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search articles..." 
                        class="w-full px-6 py-4 pr-14 text-gray-900 dark:text-white bg-white/95 dark:bg-gray-800/95 backdrop-blur rounded-full border-0 shadow-lg focus:ring-2 focus:ring-white/50 focus:outline-none placeholder-gray-400"
                    >
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-6">
                <!-- Categories -->
                <x-ui.card padding="lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Categories
                    </h3>
                    <nav class="space-y-1">
                        <a href="{{ route('posts.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg {{ request()->has('category') ? 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' : 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 font-medium' }} transition-colors">
                            <span>All Posts</span>
                            <x-ui.badge size="sm" variant="{{ request()->has('category') ? 'gray' : 'primary' }}">{{ \App\Models\Post::where('status', 'published')->count() }}</x-ui.badge>
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('posts.index', ['category' => $cat->slug]) }}" class="flex items-center justify-between px-3 py-2 rounded-lg {{ request('category') == $cat->slug ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }} transition-colors">
                                <span>{{ $cat->name }}</span>
                                <x-ui.badge size="sm" variant="{{ request('category') == $cat->slug ? 'primary' : 'gray' }}">{{ $cat->posts->count() }}</x-ui.badge>
                            </a>
                        @endforeach
                    </nav>
                </x-ui.card>

                <!-- Newsletter -->
                <x-ui.card padding="lg" class="bg-gradient-to-br from-blue-500 to-purple-600 border-0">
                    <h3 class="text-lg font-semibold text-white mb-2">Stay Updated</h3>
                    <p class="text-sm text-blue-100 mb-4">Get the latest posts delivered to your inbox.</p>
                    <form class="space-y-3">
                        <input type="email" placeholder="Enter your email" class="w-full px-4 py-2 rounded-lg bg-white/20 border-0 text-white placeholder-blue-200 focus:ring-2 focus:ring-white/50">
                        <x-ui.button variant="secondary" size="sm" class="w-full justify-center bg-white text-blue-600 hover:bg-blue-50">
                            Subscribe
                        </x-ui.button>
                    </form>
                </x-ui.card>
            </aside>

            <!-- Posts Grid -->
            <div class="lg:col-span-3">
                @if($posts->count() > 0)
                    <!-- Results Header -->
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-gray-600 dark:text-gray-400">
                            Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $posts->count() }}</span> posts
                        </p>
                        <select class="text-sm rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <option>Latest First</option>
                            <option>Oldest First</option>
                            <option>Most Popular</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                        @foreach($posts as $post)
                            <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transform hover:-translate-y-1 transition group">
                                <!-- Image -->
                                <div class="relative h-48 overflow-hidden bg-gray-200 dark:bg-gray-700">
                                    @if($post->media->first())
                                        <img src="{{ Storage::url($post->media->first()->path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                            <span class="text-white text-5xl">📝</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4 flex gap-2">
                                        @foreach($post->taxonomies->take(2) as $tax)
                                            <span class="text-xs px-3 py-1 bg-white dark:bg-gray-900 text-blue-600 dark:text-blue-400 rounded-full font-semibold">{{ $tax->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6">
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600 transition">{{ $post->title }}</a>
                                    </h2>
                                    
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}</p>
                                    
                                    <!-- Meta -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-500 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>By {{ $post->author?->name ?? 'Admin' }}</span>
                                        </div>
                                        <span>{{ $post->published_at?->format('M d, Y') ?? 'Draft' }}</span>
                                    </div>
                                    
                                    <!-- Link -->
                                    <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold transition">
                                        Read Article
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $posts->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-20">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No posts found</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                            @if(request('search'))
                                No posts match your search for "{{ request('search') }}". Try different keywords.
                            @elseif(request('category'))
                                No posts in this category yet. Check back soon!
                            @else
                                We haven't published any posts yet. Come back later for amazing content.
                            @endif
                        </p>
                        @if(request('search') || request('category'))
                            <a href="{{ route('posts.index') }}" class="mt-6 inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                View all posts
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
