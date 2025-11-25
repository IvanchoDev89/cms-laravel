<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
                @if($page->media->first())
                    <img src="{{ Storage::url($page->media->first()->path) }}" alt="{{ $page->title }}" class="w-full h-80 object-cover">
                @else
                    <div class="w-full h-80 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <span class="text-white text-5xl">📄</span>
                    </div>
                @endif

                <div class="p-8">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $page->title }}</h1>
                    
                    <div class="text-gray-600 dark:text-gray-400">
                        Updated {{ $page->updated_at->format('F j, Y') }}
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mb-8">
                <div class="prose dark:prose-invert max-w-none">
                    {!! nl2br(htmlspecialchars($page->content)) !!}
                </div>
            </div>

            <!-- Back Link -->
            <div class="text-center">
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-900 font-semibold">← Back Home</a>
            </div>
        </div>
    </div>
</div>
