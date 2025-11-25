<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Upload Media</h3>
        
        <form wire:submit.prevent="upload" class="space-y-4">
            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition"
                 onclick="document.getElementById('file-input').click()">
                <input 
                    type="file" 
                    id="file-input"
                    wire:model="file" 
                    class="hidden"
                    accept=".jpg,.jpeg,.png,.gif,.svg,.webp,.mp4,.mp3,.pdf,.doc,.docx,.zip"
                />
                @if($file)
                    <div class="text-green-600 dark:text-green-400">
                        <p class="font-semibold">{{ $file->getClientOriginalName() }}</p>
                        <p class="text-sm">{{ number_format($file->getSize() / 1024, 2) }} KB</p>
                    </div>
                @else
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-6-12v12m0 0l-3-3m3 3l3-3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-semibold">Click to upload</span> or drag and drop
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                        JPG, PNG, GIF, SVG, MP4, MP3, PDF, DOC, ZIP up to 50MB
                    </p>
                @endif
            </div>

            @error('file')
                <div class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</div>
            @enderror

            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg transition">
                <span wire:loading.remove>Upload File</span>
                <span wire:loading>
                    <span class="inline-block animate-spin">⏳</span> Uploading...
                </span>
            </button>
        </form>

        @if($uploadedMedia)
            <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-green-700 dark:text-green-400 font-semibold">✓ Media uploaded successfully!</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">File: {{ $uploadedMedia->filename }}</p>
            </div>
        @endif
    </div>
</div>
