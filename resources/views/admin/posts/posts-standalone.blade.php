@extends('layouts.app')

@section('title', 'Posts Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Posts Management</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your blog posts and content</p>
                </div>
                <a href="{{ route('admin.posts.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Post
                </a>
            </div>
            
            <div class="p-6">
                @if(isset($posts) && $posts->count() > 0)
                    <div class="mb-4">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $posts->count() }} total posts</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($posts as $post)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $post->title }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ Str::limit(strip_tags($post->content), 50) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $post->status == 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $post->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('posts.show', $post->slug) }}" 
                                               target="_blank"
                                               class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 mr-3">
                                                View
                                            </a>
                                            <a href="{{ route('admin.posts.edit', $post->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No posts</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first post.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.posts.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Post
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
