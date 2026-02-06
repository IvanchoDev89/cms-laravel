<div class="space-y-8" x-data="dashboardAnalytics()">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-blue-100">{{ now()->format('l, F j, Y') }} • Here's what's happening with your content</p>
            </div>
            <div class="hidden lg:block">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                    <div class="text-2xl font-bold">{{ $overview['totalPosts'] ?? 0 }}</div>
                    <div class="text-sm text-blue-100">Total Posts</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        <!-- Total Posts Card -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 px-2 py-1 rounded-full">+12%</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $overview['totalPosts'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-white transition-colors">Total Posts</div>
            </div>
        </div>

        <!-- Published Posts Card -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-full">+8%</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $overview['published'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-white transition-colors">Published</div>
            </div>
        </div>

        <!-- Drafts Card -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-orange-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-900/30 px-2 py-1 rounded-full">-3%</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $overview['drafts'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-white transition-colors">Drafts</div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/30 px-2 py-1 rounded-full">+24%</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $overview['totalUsers'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-white transition-colors">Active Users</div>
            </div>
        </div>

        <!-- Media Files Card -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/30 px-2 py-1 rounded-full">+15%</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $overview['media'] ?? 0 }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-white transition-colors">Media Files</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Posts Chart -->
        <div class="xl:col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Posts Published</h3>
                <span class="text-xs text-gray-500 dark:text-gray-400">Last 7 days</span>
            </div>
            <div class="relative h-64">
                <canvas id="postsChart"></canvas>
            </div>
        </div>

        <!-- Users Chart -->
        <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Growth</h3>
                <span class="text-xs text-gray-500 dark:text-gray-400">Last 30 days</span>
            </div>
            <div class="relative h-64">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Content & Activity -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Recent Posts -->
        <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Posts</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">View All →</a>
            </div>
            <div class="space-y-4">
                @foreach($recentPosts as $p)
                    <div class="group flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-2 h-2 rounded-full @if($p->status === 'published') bg-green-500 @elseif($p->status === 'draft') bg-yellow-500 @else bg-gray-500 @endif"></div>
                                <h4 class="font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ Str::limit($p->title, 60) }}</h4>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                <span>{{ $p->published_at?->format('M d, Y') ?? '—' }}</span>
                                <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 rounded-full">{{ ucfirst($p->status) }}</span>
                                <span>{{ $p->views_count ?? 0 }} views</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.posts.edit', $p->id) }}" class="px-3 py-1 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Edit</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Stats & Actions -->
        <div class="space-y-6">
            <!-- Top Authors -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Authors</h3>
                <div class="space-y-3">
                    @foreach($topAuthors as $index => $a)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr($a->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $a->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $a->posts_count ?? 0 }} posts</div>
                                </div>
                            </div>
                            <div class="text-xs font-medium text-blue-600 dark:text-blue-400">#{{ $index + 1 }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">System Info</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Storage Used</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $storageUsage }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Visitors (30d)</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $uniqueVisitors ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Avg. Load Time</span>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">245ms</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.posts.create') }}" class="w-full flex items-center gap-3 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="font-medium">New Post</span>
                    </a>
                    <a href="{{ route('admin.media.index') }}" class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span class="font-medium">Upload Media</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Posts -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Trending Posts</h3>
            <span class="text-xs text-gray-500 dark:text-gray-400">Last 30 days</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($topPosts as $tp)
                <div class="group p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                                {{ $loop->index + 1 }}
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $tp->views_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $tp->title }}</h4>
                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                        <span>{{ $tp->published_at?->format('M d') ?? '—' }}</span>
                        <span>•</span>
                        <span>{{ $tp->comments_count ?? 0 }} comments</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function dashboardAnalytics() {
            return {
                init() {
                    this.initCharts();
                },
                initCharts() {
                    // Posts Chart
                    const postsCtx = document.getElementById('postsChart');
                    if (postsCtx) {
                        new Chart(postsCtx, {
                            type: 'line',
                            data: {
                                labels: @json(array_column($postsLast7, 'label')),
                                datasets: [{
                                    label: 'Posts',
                                    data: @json(array_column($postsLast7, 'count')),
                                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                    borderColor: 'rgba(99, 102, 241, 1)',
                                    borderWidth: 3,
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        padding: 12,
                                        cornerRadius: 8
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Users Chart
                    const usersCtx = document.getElementById('usersChart');
                    if (usersCtx) {
                        new Chart(usersCtx, {
                            type: 'line',
                            data: {
                                labels: @json(array_column($usersLast30, 'label')),
                                datasets: [{
                                    label: 'New Users',
                                    data: @json(array_column($usersLast30, 'count')),
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    borderColor: 'rgba(16, 185, 129, 1)',
                                    borderWidth: 3,
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        padding: 12,
                                        cornerRadius: 8
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            }
        }
    </script>
</div>
