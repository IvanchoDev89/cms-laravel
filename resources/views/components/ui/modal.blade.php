{{--
    Modal Component - Professional modal/dialog
    
    Props:
    - open: boolean (Alpine.js variable)
    - size: 'sm' | 'md' | 'lg' | 'xl' | 'full'
    - title: string
    - hideClose: boolean
--}}

@props([
    'open' => 'open',
    'size' => 'md',
    'title' => null,
    'hideClose' => false,
])

@php
$sizes = [
    'sm' => 'max-w-md',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
    'full' => 'max-w-full mx-4',
];
@endphp

<div x-show="{{ $open }}" 
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true">
    
    {{-- Backdrop --}}
    <div x-show="{{ $open }}"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm transition-opacity"
         @click="{{ $open }} = false"
         aria-hidden="true">
    </div>
    
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="{{ $open }}"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             x-trap="{{ $open }}"
             @click.away="{{ $open }} = false"
             class="relative w-full {{ $sizes[$size] }} transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all border border-gray-200 dark:border-gray-700">
            
            {{-- Header --}}
            @if($title || !$hideClose)
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    @if($title)
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                            {{ $title }}
                        </h3>
                    @else
                        <div></div>
                    @endif
                    
                    @if(!$hideClose)
                        <button type="button" 
                                @click="{{ $open }} = false"
                                class="rounded-lg p-1 text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            @endif
            
            {{-- Content --}}
            <div class="px-6 py-4">
                {{ $slot }}
            </div>
            
            {{-- Footer --}}
            @if(isset($footer))
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
