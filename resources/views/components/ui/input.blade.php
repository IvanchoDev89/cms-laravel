{{--
    Form Input Component - Professional form input with label, error handling, and helper text
    
    Props:
    - type: text | email | password | number | tel | url | date | datetime-local | search
    - name: string
    - label: string (optional)
    - placeholder: string
    - required: boolean
    - disabled: boolean
    - readonly: boolean
    - helper: string (helper text below input)
    - error: string (error message)
    - icon: string (SVG icon to show inside input)
    - iconPosition: 'left' | 'right'
    - autocomplete: string
--}}

@props([
    'type' => 'text',
    'name' => '',
    'label' => null,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'helper' => null,
    'error' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'autocomplete' => null,
])

@php
$hasError = $error !== null;
$hasIcon = $icon !== null;

$baseClasses = 'block w-full rounded-xl border-0 py-2.5 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset transition-all duration-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6';

$stateClasses = $hasError 
    ? 'ring-red-300 dark:ring-red-700 focus:ring-red-500 bg-red-50 dark:bg-red-900/10' 
    : 'ring-gray-300 dark:ring-gray-700 focus:ring-blue-600 dark:focus:ring-blue-500 bg-white dark:bg-gray-900';

$disabledClasses = ($disabled || $readonly) ? 'disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 dark:disabled:bg-gray-800 dark:disabled:text-gray-400' : '';

$inputClasses = $baseClasses . ' ' . $stateClasses . ' ' . $disabledClasses;

if ($hasIcon && $iconPosition === 'left') {
    $inputClasses .= ' pl-10';
} elseif ($hasIcon && $iconPosition === 'right') {
    $inputClasses .= ' pr-10';
} else {
    $inputClasses .= ' px-3';
}
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
        @if($hasIcon && $iconPosition === 'left')
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-400 dark:text-gray-500 h-5 w-5">{!! $icon !!}</span>
            </div>
        @endif
        
        <input 
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('value') }}
            class="{{ $inputClasses }}"
        >
        
        @if($hasIcon && $iconPosition === 'right')
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <span class="text-gray-400 dark:text-gray-500 h-5 w-5">{!! $icon !!}</span>
            </div>
        @endif
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
