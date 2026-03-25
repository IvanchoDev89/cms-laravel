{{--
    Badge Component - Professional badge/tag component
    
    Props:
    - variant: 'primary' | 'secondary' | 'success' | 'warning' | 'danger' | 'info' | 'gray' | 'purple'
    - size: 'sm' | 'md' | 'lg'
    - pill: boolean (rounded full)
    - dot: boolean (show colored dot before text)
--}}

@props([
    'variant' => 'gray',
    'size' => 'md',
    'pill' => false,
    'dot' => false,
])

@php
$variants = [
    'primary' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-300', 'dot' => 'bg-blue-500'],
    'secondary' => ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300', 'dot' => 'bg-gray-500'],
    'success' => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-300', 'dot' => 'bg-emerald-500'],
    'warning' => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-300', 'dot' => 'bg-amber-500'],
    'danger' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-300', 'dot' => 'bg-red-500'],
    'info' => ['bg' => 'bg-cyan-100 dark:bg-cyan-900/30', 'text' => 'text-cyan-700 dark:text-cyan-300', 'dot' => 'bg-cyan-500'],
    'gray' => ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300', 'dot' => 'bg-gray-500'],
    'purple' => ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-700 dark:text-purple-300', 'dot' => 'bg-purple-500'],
];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-0.5 text-sm',
    'lg' => 'px-3 py-1 text-sm',
];

$style = $variants[$variant];
$roundedClass = $pill ? 'rounded-full' : 'rounded-md';

$classes = 'inline-flex items-center font-medium ' . $sizes[$size] . ' ' . $roundedClass . ' ' . $style['bg'] . ' ' . $style['text'];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <svg class="mr-1.5 h-1.5 w-1.5 {{ $style['dot'] }}" fill="currentColor" viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="4" />
        </svg>
    @endif
    {{ $slot }}
</span>
