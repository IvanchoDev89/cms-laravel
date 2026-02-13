@extends('layouts.app')

@section('title', 'Blog - Modern CMS')
@section('description', 'Read our latest blog posts and articles')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-br from-blue-600 to-purple-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold mb-4">Our Blog</h1>
        <p class="text-xl text-blue-100">Discover insights, tutorials, and best practices</p>
    </div>
</section>

<!-- Main Content -->
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Search -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Search</h3>
                    <input type="text" placeholder="Search posts..." class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Categories -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 sticky top-20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Categories</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('posts.index') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                                <span class="text-gray-700 dark:text-gray-300">All Posts</span>
                                <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs px-2 py-1 rounded-full">{{ \App\Models\Post::where('status', 'published')->count() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('posts.index', ['category' => $cat->slug]) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $cat->name }}</span>
                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs px-2 py-1 rounded-full">{{ $cat->posts->count() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Posts Grid -->
            <div class="lg:col-span-3">
                @if($posts->count() > 0)
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
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">No posts found. Check back soon!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
