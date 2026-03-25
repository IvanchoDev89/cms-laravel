{{--
    Alert Component - Professional alert messages
    
    Props:
    - type: 'info' | 'success' | 'warning' | 'error'
    - title: string (optional)
    - dismissible: boolean
    - icon: boolean (show icon)
--}}

@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
    'icon' => true,
])

@php
$styles = [
    'info' => [
        'bg' => 'bg-blue-50 dark:bg-blue-900/20',
        'border' => 'border-blue-200 dark:border-blue-800',
        'text' => 'text-blue-800 dark:text-blue-200',
        'icon' => 'text-blue-500',
        'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    ],
    'success' => [
        'bg' => 'bg-emerald-50 dark:bg-emerald-900/20',
        'border' => 'border-emerald-200 dark:border-emerald-800',
        'text' => 'text-emerald-800 dark:text-emerald-200',
        'icon' => 'text-emerald-500',
        'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    ],
    'warning' => [
        'bg' => 'bg-amber-50 dark:bg-amber-900/20',
        'border' => 'border-amber-200 dark:border-amber-800',
        'text' => 'text-amber-800 dark:text-amber-200',
        'icon' => 'text-amber-500',
        'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
    ],
    'error' => [
        'bg' => 'bg-red-50 dark:bg-red-900/20',
        'border' => 'border-red-200 dark:border-red-800',
        'text' => 'text-red-800 dark:text-red-200',
        'icon' => 'text-red-500',
        'iconSvg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    ],
];

$style = $styles[$type];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="rounded-xl border {{ $style['bg'] }} {{ $style['border'] }} p-4" role="alert">
    <div class="flex items-start gap-3">
        @if($icon)
            <svg class="h-5 w-5 flex-shrink-0 {{ $style['icon'] }} mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $style['iconSvg'] !!}
            </svg>
        @endif
        
        <div class="flex-1">
            @if($title)
                <h3 class="font-semibold {{ $style['text'] }} mb-1">{{ $title }}</h3>
            @endif
            <div class="text-sm {{ $style['text'] }}">
                {{ $slot }}
            </div>
        </div>
        
        @if($dismissible)
            <button @click="show = false" type="button" class="flex-shrink-0 -mr-1 -mt-1 p-1.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition-colors {{ $style['text'] }}">
                <span class="sr-only">Dismiss</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        @endif
    </div>
</div>
