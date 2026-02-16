@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                @if(auth()->check())
                    Welcome back, {{ auth()->user()->name }}!
                @else
                    Welcome to Dashboard
                @endif
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                This is the dashboard page.
            </p>
        </div>
    </div>
</div>
@endsection
