{{--
    Textarea Component - Professional textarea with auto-resize option
    
    Props:
    - name: string
    - label: string (optional)
    - placeholder: string
    - rows: int (default 4)
    - required: boolean
    - disabled: boolean
    - helper: string (helper text below textarea)
    - error: string (error message)
    - autoResize: boolean (auto resize based on content)
    - maxLength: int (character limit)
--}}

@props([
    'name' => '',
    'label' => null,
    'placeholder' => '',
    'rows' => 4,
    'required' => false,
    'disabled' => false,
    'helper' => null,
    'error' => null,
    'autoResize' => false,
    'maxLength' => null,
])

@php
$hasError = $error !== null;

$classes = 'block w-full rounded-xl border-0 py-3 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6 resize-y';

if ($hasError) {
    $classes .= ' ring-red-300 dark:ring-red-700 focus:ring-red-500 bg-red-50 dark:bg-red-900/10';
} else {
    $classes .= ' ring-gray-300 dark:ring-gray-700 focus:ring-blue-600 dark:focus:ring-blue-500 bg-white dark:bg-gray-900';
}

if ($disabled) {
    $classes .= ' disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 dark:disabled:bg-gray-800';
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
    
    <div class="relative" @if($autoResize) x-data="{ resize() { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } }" @input="resize()" @if($rows < 3) x-init="resize()" @endif @endif>
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            rows="{{ $rows }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($maxLength) maxlength="{{ $maxLength }}" @endif
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->whereStartsWith('x-') }}
            class="{{ $classes }}"
        >{{ $slot }}</textarea>
        
        @if($maxLength)
            <div class="absolute bottom-2 right-2 text-xs text-gray-400 pointer-events-none">
                <span x-text="$refs.{{ $name }} ? $refs.{{ $name }}.value.length : 0">0</span>/{{ $maxLength }}
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
