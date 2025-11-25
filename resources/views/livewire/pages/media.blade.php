<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Media Manager</h1>
            
            <div class="space-y-8">
                <!-- Upload Section -->
                <div>
                    <livewire:components.media-uploader lazy />
                </div>

                <!-- Media Library Section -->
                <div>
                    <livewire:components.media-manager />
                </div>
            </div>
        </div>
    </div>
</div>
