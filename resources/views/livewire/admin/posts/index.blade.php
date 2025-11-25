<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Posts</h1>
                <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                    ➕ New Post
                </a>
            </div>

            @if(session('message'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-green-700 dark:text-green-400">✓ {{ session('message') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <div class="flex gap-4 mb-6">
                    <input 
                        type="text" 
                        wire:model.live="search" 
                        placeholder="Search posts..." 
                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                    />
                    <select 
                        wire:model.live="status" 
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white"
                    >
                        <option value="">All Status</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                @if($posts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Title</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Author</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Date</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($posts as $post)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $post->title }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                @if($post->status === 'published') bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-400
                                                @elseif($post->status === 'draft') bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-400
                                                @else bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-400
                                                @endif">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $post->author?->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $post->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-right text-sm space-x-2">
                                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Edit</a>
                                            <button wire:click="deletePage({{ $post->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
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
                        <p class="text-gray-500 dark:text-gray-400">No posts found. <a href="{{ route('admin.posts.create') }}" class="text-blue-600 hover:underline">Create one</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
