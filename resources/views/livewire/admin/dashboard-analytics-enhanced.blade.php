<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Header -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Welcome back! Here's an overview of your CMS performance.</p>
        </div>

        <!-- Overview Cards with Trends -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Total Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Posts</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $overview['totalPosts'] ?? 0 }}</div>
                    </div>
                    <div class="text-3xl text-blue-600">📝</div>
                </div>
                <div class="flex items-center gap-1 text-sm">
                    @if ($postsTrend > 0)
                        <span class="text-green-600 font-medium">↑ {{ number_format($postsTrend, 1) }}%</span>
                        <span class="text-gray-500">vs last week</span>
                    @elseif ($postsTrend < 0)
                        <span class="text-red-600 font-medium">↓ {{ number_format(abs($postsTrend), 1) }}%</span>
                        <span class="text-gray-500">vs last week</span>
                    @else
                        <span class="text-gray-500">No change</span>
                    @endif
                </div>
            </div>

            <!-- Published Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Published</div>
                        <div class="text-3xl font-bold text-green-600">{{ $overview['published'] ?? 0 }}</div>
                    </div>
                    <div class="text-3xl">✅</div>
                </div>
                <div class="text-sm text-gray-500">{{ number_format(($overview['published'] / max($overview['totalPosts'], 1)) * 100, 1) }}% published</div>
            </div>

            <!-- Drafts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Drafts</div>
                        <div class="text-3xl font-bold text-yellow-600">{{ $overview['drafts'] ?? 0 }}</div>
                    </div>
                    <div class="text-3xl">📋</div>
                </div>
                <div class="text-sm text-gray-500">{{ number_format(($overview['drafts'] / max($overview['totalPosts'], 1)) * 100, 1) }}% in draft</div>
            </div>

            <!-- Active Users -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Active Users</div>
                        <div class="text-3xl font-bold text-purple-600">{{ $overview['totalUsers'] ?? 0 }}</div>
                    </div>
                    <div class="text-3xl">👥</div>
                </div>
                <div class="flex items-center gap-1 text-sm">
                    @if ($usersTrend > 0)
                        <span class="text-green-600 font-medium">↑ {{ number_format($usersTrend, 1) }}%</span>
                        <span class="text-gray-500">vs last month</span>
                    @elseif ($usersTrend < 0)
                        <span class="text-red-600 font-medium">↓ {{ number_format(abs($usersTrend), 1) }}%</span>
                        <span class="text-gray-500">vs last month</span>
                    @else
                        <span class="text-gray-500">Stable</span>
                    @endif
                </div>
            </div>

            <!-- Media Files -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Media Files</div>
                        <div class="text-3xl font-bold text-pink-600">{{ $overview['media'] ?? 0 }}</div>
                    </div>
                    <div class="text-3xl">🖼️</div>
                </div>
                <div class="text-sm text-gray-500">{{ $storageUsage }}</div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Posts Published Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Posts Published (7 Days)</h3>
                <canvas id="postsChart" height="200"></canvas>
            </div>

            <!-- New Users Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">New Users (30 Days)</h3>
                <canvas id="usersChart" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Activity & Quick Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Posts -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Posts</h3>
                    <a href="{{ route('admin.posts.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">View all →</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentPosts as $post)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-900 dark:text-white">{{ Str::limit($post->title, 40) }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span class="inline-block px-2 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 capitalize">{{ $post->status }}</span>
                                    <span class="ml-2 text-gray-500">{{ $post->published_at?->format('M d, Y') ?? '—' }}</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="ml-4 text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium">Edit →</a>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <p>No recent posts. Create your first post!</p>
                            <a href="{{ route('admin.posts.create') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium">Create Post →</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Stats Sidebar -->
            <div class="space-y-4">
                <!-- Top Authors -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Top Authors</h3>
                    <ol class="list-decimal list-inside space-y-2">
                        @forelse($topAuthors as $author)
                            <li class="flex justify-between items-center text-sm">
                                <span class="text-gray-900 dark:text-gray-100">{{ $author->name }}</span>
                                <span class="text-gray-500 text-xs">{{ $author->posts_count ?? 0 }}</span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">No authors yet</li>
                        @endforelse
                    </ol>
                </div>

                <!-- Storage Info -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Storage & Engagement</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Storage Used</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $storageUsage }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Unique Visitors (30d)</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $uniqueVisitors ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Posts by Views -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Posts (30 Days)</h3>
            @if($topPosts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($topPosts as $index => $post)
                        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $index + 1 }}</div>
                                    <div class="font-semibold text-sm text-gray-900 dark:text-white mt-2">{{ Str::limit($post->title, 35) }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-blue-600">{{ $post->views_count ?? 0 }}</div>
                                    <div class="text-xs text-gray-500">views</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No posts with views yet. Keep creating content!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Detect dark mode
            const isDarkMode = document.documentElement.classList.contains('dark') || 
                             window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            const chartColors = {
                text: isDarkMode ? '#9CA3AF' : '#6B7280',
                gridLine: isDarkMode ? '#374151' : '#E5E7EB',
            };

            // Posts Published Chart
            const postsCtx = document.getElementById('postsChart');
            if (postsCtx) {
                new Chart(postsCtx, {
                    type: 'line',
                    data: {
                        labels: @json(array_column($postsLast7, 'label')),
                        datasets: [{
                            label: 'Posts Published',
                            data: @json(array_column($postsLast7, 'count')),
                            backgroundColor: 'rgba(99, 102, 241, 0.08)',
                            borderColor: 'rgba(99, 102, 241, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { color: chartColors.text },
                                grid: { color: chartColors.gridLine },
                            },
                            x: {
                                ticks: { color: chartColors.text },
                                grid: { color: chartColors.gridLine },
                            },
                        },
                    }
                });
            }

            // New Users Chart
            const usersCtx = document.getElementById('usersChart');
            if (usersCtx) {
                new Chart(usersCtx, {
                    type: 'line',
                    data: {
                        labels: @json(array_column($usersLast30, 'label')),
                        datasets: [{
                            label: 'New Users',
                            data: @json(array_column($usersLast30, 'count')),
                            backgroundColor: 'rgba(16, 185, 129, 0.08)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                            pointRadius: 3,
                            pointHoverRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: false },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { color: chartColors.text },
                                grid: { color: chartColors.gridLine },
                            },
                            x: {
                                ticks: { color: chartColors.text },
                                grid: { color: chartColors.gridLine },
                            },
                        },
                    }
                });
            }
        });
    </script>
</div>
