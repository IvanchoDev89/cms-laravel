<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $postId ? 'Edit Post' : 'Create Post' }}
                </h1>
                <a href="{{ route('admin.posts.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">← Back</a>
            </div>

            @if(session('message'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-green-700 dark:text-green-400">✓ {{ session('message') }}</p>
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                    <!-- Title -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Title</label>
                        <input 
                            type="text" 
                            wire:model.blur="title" 
                            @blur="$wire.generateSlug()"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Post title"
                        />
                        @error('title') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Slug</label>
                        <input 
                            type="text" 
                            wire:model="slug" 
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="post-slug"
                        />
                        @error('slug') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Excerpt</label>
                        <textarea 
                            wire:model="excerpt" 
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            placeholder="Short summary of the post"
                            rows="3"
                        ></textarea>
                    </div>

                    <!-- Content -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Content</label>
                        <livewire:components.rich-text-editor wire:model="content" />
                        @error('content') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select 
                                wire:model="status" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            >
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Publish Date</label>
                            <input 
                                type="datetime-local" 
                                wire:model="published_at" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                    </div>

                    <!-- Taxonomies -->
                    @if($taxonomies->count() > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Categories & Tags</label>
                            <div class="space-y-2">
                                @foreach($taxonomies as $tax)
                                    <label class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            wire:model="selectedTaxonomies" 
                                            value="{{ $tax->id }}"
                                            class="rounded"
                                        />
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $tax->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Submit -->
                <div class="flex gap-4">
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-semibold py-2 px-6 rounded-lg transition"
                    >
                        <span wire:loading.remove>{{ $postId ? 'Update Post' : 'Create Post' }}</span>
                        <span wire:loading>Saving...</span>
                    </button>
                    <a href="{{ route('admin.posts.index') }}" class="bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-white font-semibold py-2 px-6 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
