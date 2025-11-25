<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Media Library</h3>
            <div class="w-64">
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Search media..." 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm"
                />
            </div>
        </div>

        @if($media->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($media as $item)
                    <div class="relative group bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden h-40 flex items-center justify-center">
                        @if(str_contains($item->mime_type, 'image'))
                            <img src="{{ Storage::url($item->path) }}" alt="{{ $item->filename }}" class="w-full h-full object-cover">
                        @elseif(str_contains($item->mime_type, 'video'))
                            <div class="text-center">
                                <p class="text-gray-600 dark:text-gray-400 text-2xl">🎬</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $item->filename }}</p>
                            </div>
                        @elseif(str_contains($item->mime_type, 'audio'))
                            <div class="text-center">
                                <p class="text-gray-600 dark:text-gray-400 text-2xl">🎵</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $item->filename }}</p>
                            </div>
                        @else
                            <div class="text-center">
                                <p class="text-gray-600 dark:text-gray-400 text-2xl">📄</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $item->filename }}</p>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                            <a href="{{ Storage::url($item->path) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full">
                                <span class="text-xs">👁️</span>
                            </a>
                            <button wire:click="deleteMedia({{ $item->id }})" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full">
                                <span class="text-xs">🗑️</span>
                            </button>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 truncate">
                            {{ $item->filename }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $media->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">No media found. Start by uploading your first file!</p>
            </div>
        @endif
    </div>
</div>
