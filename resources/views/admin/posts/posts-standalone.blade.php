<!DOCTYPE html>
<html>
<head>
    <title>Posts Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-gray-50 p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Posts Management</h1>
        
        @if(isset($posts) && $posts->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="mb-4">
                    <span class="text-sm text-gray-600">{{ $posts->count() }} total posts</span>
                </div>
                
                <div class="space-y-4">
                    @foreach($posts as $post)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900">{{ $post->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $post->created_at->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-2">No posts found</h3>
                <p class="text-gray-600">Get started by creating your first blog post.</p>
            </div>
        @endif
    </div>
</body>
</html>
