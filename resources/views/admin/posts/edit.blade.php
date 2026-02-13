@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Post</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Modify your post content and settings</p>
            </div>
            
            <div class="p-6">
                <form method="POST" action="{{ route('admin.posts.update', $post->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Title
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $post->title) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                               required>
                    </div>
                    
                    <div class="mb-6">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Content
                        </label>
                        <textarea id="content" 
                                  name="content" 
                                  rows="10"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                  required>{{ old('content', $post->content) }}</textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status
                        </label>
                        <select id="status" 
                                name="status"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.posts.index') }}" 
                           class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Cancel
                        </a>
                        
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
