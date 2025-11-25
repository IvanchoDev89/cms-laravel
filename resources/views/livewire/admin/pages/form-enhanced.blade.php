<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ $pageId ? 'Edit Page' : 'Create New Page' }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                {{ $pageId ? 'Update your page content and SEO settings' : 'Create a new static page' }}
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session('message'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-green-800 dark:text-green-200">{{ session('message') }}</p>
            </div>
        @endif

        <!-- Form -->
        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title & Slug -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Title</label>
                            <input
                                wire:model="title"
                                type="text"
                                placeholder="Enter page title"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Slug</label>
                            <div class="flex gap-2">
                                <input
                                    wire:model="slug"
                                    type="text"
                                    placeholder="page-slug"
                                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                <button
                                    wire:click="generateSlug"
                                    type="button"
                                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-medium transition"
                                >
                                    Generate
                                </button>
                            </div>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Excerpt</label>
                            <textarea
                                wire:model="excerpt"
                                rows="2"
                                placeholder="Brief summary of the page"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ></textarea>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Content</label>
                        <livewire:components.rich-text-editor wire:model="content" />
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">SEO Settings</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                Meta Title <span class="text-xs text-gray-500">({{ strlen($meta_title) }}/60)</span>
                            </label>
                            <input
                                wire:model="meta_title"
                                type="text"
                                placeholder="Leave empty to use page title"
                                maxlength="60"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            @error('meta_title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                Meta Description <span class="text-xs text-gray-500">({{ strlen($meta_description) }}/160)</span>
                            </label>
                            <textarea
                                wire:model="meta_description"
                                rows="2"
                                maxlength="160"
                                placeholder="Brief description for search engines"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ></textarea>
                            @error('meta_description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Meta Keywords</label>
                            <input
                                wire:model="meta_keywords"
                                type="text"
                                placeholder="keyword1, keyword2, keyword3"
                                maxlength="255"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            @error('meta_keywords')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actions</h3>

                        <div class="flex flex-col gap-3 pt-4">
                            <button
                                type="submit"
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition"
                            >
                                {{ $pageId ? 'Update' : 'Create' }}
                            </button>
                            <a
                                href="{{ route('admin.pages.index') }}"
                                class="w-full px-4 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition text-center"
                            >
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
