@extends('layouts.admin-sidebar')

@section('title', 'Dashboard - Admin')

@section('content')
<div x-data="{ 
    dateRange: '7d',
    loading: false,
    stats: {
        posts: {{ \App\Models\Post::count() }},
        pages: {{ \App\Models\Page::count() }},
        users: {{ \App\Models\User::count() }},
        views: {{ \App\Models\PostView::count() }},
    }
}" class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Welcome back, {{ auth()->user()->name }}! Here's what's happening.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <select x-model="dateRange" class="rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm">
                <option value="7d">Last 7 days</option>
                <option value="30d">Last 30 days</option>
                <option value="90d">Last 3 months</option>
                <option value="1y">Last year</option>
            </select>
            
            <x-ui.button variant="secondary" size="sm" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>'>
                Export
            </x-ui.button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Posts -->
        <x-ui.card hover gradient padding="lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Posts</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white" x-text="stats.posts">0</p>
                    <div class="mt-2 flex items-center text-sm text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>+12% this week</span>
                    </div>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </x-ui.card>

        <!-- Pages -->
        <x-ui.card hover gradient padding="lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pages</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white" x-text="stats.pages">0</p>
                    <div class="mt-2 flex items-center text-sm text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>+2 new</span>
                    </div>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </x-ui.card>

        <!-- Users -->
        <x-ui.card hover gradient padding="lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Users</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white" x-text="stats.users">0</p>
                    <div class="mt-2 flex items-center text-sm text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>+8% this month</span>
                    </div>
                </div>
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a1 1 0 11-2 0 1 1 0 012 0zM2.05 18.63a1 1 0 011.41 0 1 1 0 010 1.42 1 1 0 01-1.41 0 1 1 0 010-1.42zM19 8a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                </div>
            </div>
        </x-ui.card>

        <!-- Views -->
        <x-ui.card hover gradient padding="lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Views</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white" x-text="stats.views.toLocaleString()">0</p>
                    <div class="mt-2 flex items-center text-sm text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <span>+24% this week</span>
                    </div>
                </div>
                <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Posts -->
        <x-ui.card class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Posts</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    View all →
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Title</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Date</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-500 dark:text-gray-400">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse(\App\Models\Post::latest()->limit(5)->get() as $post)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white truncate max-w-xs">{{ $post->title }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">by {{ $post->author?->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                $statusVariant = match($post->status) {
                                    'published' => 'success',
                                    'draft' => 'warning',
                                    default => 'gray',
                                };
                                @endphp
                                <x-ui.badge variant="{{ $statusVariant }}" dot>{{ ucfirst($post->status) }}</x-ui.badge>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $post->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ number_format($post->view_count) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                No posts yet. <a href="{{ route('admin.posts.create') }}" class="text-blue-600 hover:underline">Create your first post</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-ui.card>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <x-ui.button href="{{ route('admin.posts.create') }}" variant="primary" class="w-full justify-start" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>'>
                        New Post
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.pages.index') }}" variant="secondary" class="w-full justify-start" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>'>
                        Manage Pages
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.media.index') }}" variant="secondary" class="w-full justify-start" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>
                        Media Library
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.users.index') }}" variant="secondary" class="w-full justify-start" icon='<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a1 1 0 11-2 0 1 1 0 012 0zM2.05 18.63a1 1 0 011.41 0 1 1 0 010 1.42 1 1 0 01-1.41 0 1 1 0 010-1.42zM19 8a2 2 0 100-4 2 2 0 000 4z"/></svg>'>
                        Manage Users
                    </x-ui.button>
                </div>
            </x-ui.card>

            <!-- System Status -->
            <x-ui.card class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border-emerald-200 dark:border-emerald-800">
                <h3 class="text-lg font-semibold text-emerald-900 dark:text-emerald-100 mb-4">System Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-emerald-800 dark:text-emerald-200">Laravel</span>
                        <x-ui.badge variant="success" size="sm">v{{ app()->version() }}</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-emerald-800 dark:text-emerald-200">PHP</span>
                        <x-ui.badge variant="success" size="sm">v{{ phpversion() }}</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-emerald-800 dark:text-emerald-200">Environment</span>
                        <x-ui.badge variant="{{ app()->environment('production') ? 'success' : 'warning' }}" size="sm">{{ app()->environment() }}</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-emerald-800 dark:text-emerald-200">Database</span>
                        <x-ui.badge variant="success" size="sm">Connected</x-ui.badge>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>

    <!-- Alert Example (Demo) -->
    <div class="mt-6">
        <x-ui.alert type="info" title="Tip: Toast Notifications" dismissible>
            Try clicking buttons to see toast notifications in action. Use <code class="bg-gray-100 dark:bg-gray-700 px-1 py-0.5 rounded text-sm">showToast()</code> in your JavaScript to trigger notifications.
        </x-ui.alert>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Demo: Show welcome toast after page loads
    setTimeout(() => {
        showToast('Welcome to your dashboard!', 'success', 'Hello {{ auth()->user()->name }}');
    }, 1000);
</script>
@endpush
