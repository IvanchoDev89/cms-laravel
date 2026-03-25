{{--
    Card Component - Professional card container
    
    Props:
    - padding: 'none' | 'sm' | 'md' | 'lg'
    - shadow: 'none' | 'sm' | 'md' | 'lg'
    - border: boolean
    - hover: boolean (adds hover effect)
    - clickable: boolean (makes card clickable with hover state)
    - href: string (optional, wraps card in anchor)
    - gradient: boolean (adds gradient border effect)
--}}

@props([
    'padding' => 'md',
    'shadow' => 'md',
    'border' => true,
    'hover' => false,
    'clickable' => false,
    'href' => null,
    'gradient' => false,
])

@php
$baseClasses = 'bg-white dark:bg-gray-800 overflow-hidden transition-all duration-200';

$paddingClasses = [
    'none' => '',
    'sm' => 'p-3',
    'md' => 'p-5',
    'lg' => 'p-6',
][$padding];

$shadowClasses = [
    'none' => '',
    'sm' => 'shadow-sm',
    'md' => 'shadow-md',
    'lg' => 'shadow-lg',
][$shadow];

$borderClasses = $border ? 'border border-gray-200 dark:border-gray-700' : '';
$roundedClass = 'rounded-xl';

$hoverClasses = '';
if ($hover || $clickable) {
    $hoverClasses = 'hover:shadow-lg hover:-translate-y-0.5 cursor-pointer';
}

$gradientClasses = '';
if ($gradient) {
    $gradientClasses = 'relative before:absolute before:inset-0 before:p-[1px] before:bg-gradient-to-br before:from-blue-500/20 before:via-purple-500/20 before:to-pink-500/20 before:rounded-xl before:-z-10';
}

$classes = $baseClasses . ' ' . $paddingClasses . ' ' . $shadowClasses . ' ' . $borderClasses . ' ' . $roundedClass . ' ' . $hoverClasses . ' ' . $gradientClasses;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <div {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </div>
@endif
