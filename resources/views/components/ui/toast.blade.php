{{--
    Toast Container & Notifications
    Include this in your layout to enable toast notifications
--}}
<div 
    x-data="{ 
        toasts: [],
        add(toast) {
            toast.id = Date.now();
            this.toasts.push(toast);
            setTimeout(() => this.remove(toast.id), toast.duration || 5000);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    x-on:toast.window="add($event.detail)"
    class="fixed bottom-4 right-4 z-50 flex flex-col gap-3"
    aria-live="polite"
    aria-atomic="true"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform translate-x-full opacity-0"
            x-transition:enter-end="transform translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="transform translate-x-0 opacity-100"
            x-transition:leave-end="transform translate-x-full opacity-0"
            :class="{
                'bg-white dark:bg-gray-800 border-l-4': true,
                'border-blue-500': toast.type === 'info',
                'border-emerald-500': toast.type === 'success',
                'border-amber-500': toast.type === 'warning',
                'border-red-500': toast.type === 'error'
            }"
            class="pointer-events-auto w-80 rounded-xl shadow-lg ring-1 ring-black/5 dark:ring-white/10 p-4"
            role="alert"
        >
            <div class="flex items-start gap-3">
                <div x-show="toast.type === 'success'" class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div x-show="toast.type === 'error'" class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
                <div x-show="toast.type === 'warning'" class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/30">
                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
                <div x-show="toast.type === 'info' || !toast.type" class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="flex-1 min-w-0">
                    <p x-show="toast.title" x-text="toast.title" class="text-sm font-medium text-gray-900 dark:text-gray-100"></p>
                    <p x-text="toast.message" class="text-sm text-gray-500 dark:text-gray-400" :class="toast.title ? 'mt-1' : ''"></p>
                </div>
                
                <button 
                    @click="remove(toast.id)"
                    class="flex-shrink-0 rounded-lg p-1 text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Progress bar -->
            <div class="mt-3 h-1 w-full bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                <div 
                    class="h-full transition-all duration-100 ease-linear"
                    :class="{
                        'bg-blue-500': toast.type === 'info' || !toast.type,
                        'bg-emerald-500': toast.type === 'success',
                        'bg-amber-500': toast.type === 'warning',
                        'bg-red-500': toast.type === 'error'
                    }"
                    x-bind:style="'animation: shrink ' + (toast.duration || 5000) + 'ms linear forwards'"
                ></div>
            </div>
        </div>
    </template>
</div>

<style>
@keyframes shrink {
    from { width: 100%; }
    to { width: 0%; }
}
</style>

{{-- Trigger helper --}}
<script>
function showToast(message, type = 'info', title = null, duration = 5000) {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { message, type, title, duration }
    }));
}

// Helper functions for different toast types
function toastSuccess(message, title = null, duration = 5000) {
    showToast(message, 'success', title, duration);
}

function toastError(message, title = null, duration = 5000) {
    showToast(message, 'error', title, duration);
}

function toastWarning(message, title = null, duration = 5000) {
    showToast(message, 'warning', title, duration);
}

function toastInfo(message, title = null, duration = 5000) {
    showToast(message, 'info', title, duration);
}
</script>
