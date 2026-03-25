{{--
    Button Component - Professional button with multiple variants
    
    Props:
    - variant: 'primary' | 'secondary' | 'danger' | 'warning' | 'success' | 'ghost'
    - size: 'sm' | 'md' | 'lg' | 'xl'
    - type: 'button' | 'submit' | 'reset'
    - disabled: boolean
    - loading: boolean
    - icon: string (optional)
    - iconPosition: 'left' | 'right'
    - href: string (optional, renders as anchor)
    - target: '_self' | '_blank'
    - onclick: string (optional)
--}}

@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'href' => null,
    'target' => '_self',
    'onclick' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center gap-2 font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$sizeClasses = [
    'sm' => 'px-3 py-1.5 text-xs rounded-lg',
    'md' => 'px-4 py-2 text-sm rounded-lg',
    'lg' => 'px-5 py-2.5 text-base rounded-xl',
    'xl' => 'px-6 py-3 text-lg rounded-xl',
][$size];

$variantClasses = [
    'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700 shadow-sm hover:shadow-md',
    'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 dark:bg-red-600 dark:hover:bg-red-700 shadow-sm hover:shadow-md',
    'warning' => 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-500 dark:bg-amber-500 dark:hover:bg-amber-600 shadow-sm hover:shadow-md',
    'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500 dark:bg-emerald-600 dark:hover:bg-emerald-700 shadow-sm hover:shadow-md',
    'ghost' => 'bg-transparent text-gray-700 hover:bg-gray-100 focus:ring-gray-500 dark:text-gray-300 dark:hover:bg-gray-800',
][$variant];

$iconSize = match($size) {
    'sm' => 'w-3.5 h-3.5',
    'md' => 'w-4 h-4',
    'lg' => 'w-5 h-5',
    'xl' => 'w-5 h-5',
};

$classes = $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses;
@endphp

@if($href)
    <a href="{{ $href }}" target="{{ $target }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <svg class="{{ $iconSize }} animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            <span class="{{ $iconSize }}">{!! $icon !!}</span>
        @endif
        
        <span>{{ $slot }}</span>
        
        @if($icon && $iconPosition === 'right' && !$loading)
            <span class="{{ $iconSize }}">{!! $icon !!}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $disabled || $loading ? 'disabled' : '' }} @if($onclick) onclick="{{ $onclick }}" @endif {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <svg class="{{ $iconSize }} animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            <span class="{{ $iconSize }}">{!! $icon !!}</span>
        @endif
        
        <span>{{ $slot }}</span>
        
        @if($icon && $iconPosition === 'right' && !$loading)
            <span class="{{ $iconSize }}">{!! $icon !!}</span>
        @endif
    </button>
@endif
