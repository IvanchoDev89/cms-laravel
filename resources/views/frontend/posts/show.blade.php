@extends('layouts.app')

@section('title', $post->title . ' - ' . config('app.name', 'Blog'))
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')

<!-- Article Header -->
<article class="bg-white dark:bg-gray-900">
    <!-- Featured Image -->
    <div class="relative w-full h-[400px] md:h-[500px] lg:h-[600px] overflow-hidden">
        @if($post->media->first())
            <img src="{{ Storage::url($post->media->first()->path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        @else
            <div class="w-full h-full bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center">
                <svg class="w-32 h-32 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        @endif
        
        <!-- Overlay Content -->
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-sm text-white/80 mb-4">
                    <a href="/" class="hover:text-white">Home</a>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <a href="{{ route('posts.index') }}" class="hover:text-white">Blog</a>
                </nav>
                
                <!-- Categories -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($post->taxonomies as $tax)
                        <a href="{{ route('posts.index', ['category' => $tax->slug]) }}" class="inline-block px-3 py-1 bg-white/20 backdrop-blur text-white text-sm rounded-full hover:bg-white/30 transition font-medium">
                            {{ $tax->name }}
                        </a>
                    @endforeach
                </div>
                
                <!-- Title -->
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">{{ $post->title }}</h1>
                
                <!-- Meta Information -->
                <div class="flex flex-wrap gap-4 text-white/80 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-medium">
                            {{ substr($post->author?->name ?? 'A', 0, 1) }}
                        </div>
                        <span>By <strong class="text-white">{{ $post->author?->name ?? 'Admin' }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H8a2 2 0 01-2-2V7z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $post->published_at->format('F j, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $post->view_count }} views</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.606 12.97a.75.75 0 01-.992 1.084A9 9 0 1110 18a9.003 9.003 0 01-5.394-1.946.75.75 0 01.992-1.084A7.5 7.5 0 1010 16.5a7.5 7.5 0 01-5.394-2.53z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ ceil(str_word_count($post->content) / 200) }} min read</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Excerpt -->
        @if($post->excerpt)
            <p class="text-xl text-gray-700 dark:text-gray-300 italic mb-8 leading-relaxed">{{ $post->excerpt }}</p>
        @endif
    </div>
</article>

<!-- Article Body -->
<div class="bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-12 prose dark:prose-invert max-w-none">
            {!! nl2br(htmlspecialchars($post->content)) !!}
        </div>

        <!-- Share Buttons -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-12">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Share this article</h3>
            <div class="flex gap-4">
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                    </svg>
                    Share on Twitter
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18.901 1.153h3.395c1.125 0 2.045.92 2.045 2.045v3.395c0 1.125-.92 2.045-2.045 2.045h-5.62v9.624h-3.842V8.637H9.172c-.927 0-1.683-.756-1.683-1.684V3.633c0-.927.756-1.683 1.683-1.683h2.308V1.787c0-2.231 1.812-4.039 4.039-4.039z"/>
                    </svg>
                    Share on Facebook
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('posts.show', $post->slug)) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M16.337 0H3.663C1.638 0 0 1.638 0 3.663v12.674C0 18.362 1.638 20 3.663 20h12.674C18.362 20 20 18.362 20 16.337V3.663C20 1.638 18.362 0 16.337 0zM6.25 17.5h-2.5V9h2.5v8.5zm-1.25-9.5c-.826 0-1.5-.674-1.5-1.5S4.174 5 5 5s1.5.674 1.5 1.5-0.674 1.5-1.5 1.5zm12.25 9.5h-2.5v-4.5c0-1.103-.897-2-2-2s-2 .897-2 2v4.5h-2.5V9h2.5v1.354c.551-.886 1.616-1.354 2.5-1.354 2.209 0 4 1.791 4 4v4.5z"/>
                    </svg>
                    Share on LinkedIn
                </a>
            </div>
        </div>

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Related Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('posts.show', $related->slug) }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transform hover:-translate-y-1 transition group">
                            <div class="relative h-40 overflow-hidden bg-gray-200 dark:bg-gray-700">
                                @if($related->media->first())
                                    <img src="{{ Storage::url($related->media->first()->path) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-purple-400 to-purple-600"></div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white line-clamp-2 mb-2">{{ $related->title }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $related->published_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12 mt-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Loved this article?</h2>
        <p class="text-lg mb-6">Subscribe to get more posts delivered to your inbox</p>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('posts.index') }}" class="px-6 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition">
                Browse More Articles
            </a>
        </div>
    </div>
</section>

@endsection
