{{--
    Select Component - Professional dropdown/select input
    
    Props:
    - name: string
    - label: string (optional)
    - options: array [value => label]
    - placeholder: string
    - required: boolean
    - disabled: boolean
    - helper: string
    - error: string
    - icon: string (optional)
--}}

@props([
    'name' => '',
    'label' => null,
    'options' => [],
    'placeholder' => 'Select an option',
    'required' => false,
    'disabled' => false,
    'helper' => null,
    'error' => null,
    'icon' => null,
])

@php
$hasError = $error !== null;

$baseClasses = 'block w-full rounded-xl border-0 py-2.5 pl-3 pr-10 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6 appearance-none bg-transparent';

$stateClasses = $hasError 
    ? 'ring-red-300 dark:ring-red-700 focus:ring-red-500 bg-red-50 dark:bg-red-900/10' 
    : 'ring-gray-300 dark:ring-gray-700 focus:ring-blue-600 dark:focus:ring-blue-500 bg-white dark:bg-gray-900';

$classes = $baseClasses . ' ' . $stateClasses;
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-400 dark:text-gray-500 h-5 w-5">{!! $icon !!}</span>
            </div>
        @endif
        
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->whereStartsWith('wire:') }}
            class="{{ $classes }} {{ $icon ? 'pl-10' : '' }}"
        >
            @if($placeholder)
                <option value="" disabled {{ !$slot ? 'selected' : '' }}>{{ $placeholder }}</option>
            @endif
            
            @foreach($options as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
            
            {{ $slot }}
        </select>
        
        {{-- Chevron icon --}}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
            </svg>
        </div>
    </div>
    
    @if($helper && !$hasError)
        <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">{{ $helper }}</p>
    @endif
    
    @if($hasError)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ $error }}
        </p>
    @endif
</div>
