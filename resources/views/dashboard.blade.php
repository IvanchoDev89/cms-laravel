@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Dashboard</h1>

    <div class="mb-6">
        <livewire:admin.dashboard-analytics />
    </div>

</div>

@endsection
