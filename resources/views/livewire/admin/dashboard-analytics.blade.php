<div class="space-y-6">
    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="text-sm text-gray-500">Total Posts</div>
            <div class="text-2xl font-bold">{{ $overview['totalPosts'] ?? 0 }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="text-sm text-gray-500">Published</div>
            <div class="text-2xl font-bold text-green-600">{{ $overview['published'] ?? 0 }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="text-sm text-gray-500">Drafts</div>
            <div class="text-2xl font-bold text-yellow-500">{{ $overview['drafts'] ?? 0 }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="text-sm text-gray-500">Active Users</div>
            <div class="text-2xl font-bold">{{ $overview['totalUsers'] ?? 0 }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <div class="text-sm text-gray-500">Media Files</div>
            <div class="text-2xl font-bold">{{ $overview['media'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Posts Published (Last 7 days)</h3>
            <canvas id="postsChart" height="160"></canvas>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold mb-4">New Users (Last 30 days)</h3>
            <canvas id="usersChart" height="160"></canvas>
        </div>
    </div>

    <!-- Recent & Top Authors -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold mb-4">Recent Posts</h3>
            <ul class="space-y-3">
                @foreach($recentPosts as $p)
                    <li class="flex items-center justify-between bg-gray-50 dark:bg-gray-900 rounded p-3">
                        <div>
                            <div class="font-semibold text-sm">{{ $p->title }}</div>
                            <div class="text-xs text-gray-500">{{ $p->published_at?->format('M d, Y') ?? '—' }} • {{ ucfirst($p->status) }}</div>
                        </div>
                        <a href="{{ route('admin.posts.edit', $p->id) }}" class="text-sm text-blue-600">Edit →</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Top Authors</h3>
            <ol class="list-decimal list-inside space-y-2">
                @foreach($topAuthors as $a)
                    <li class="flex justify-between items-center">
                        <div class="text-sm">{{ $a->name }}</div>
                        <div class="text-sm text-gray-500">{{ $a->posts_count ?? 0 }} posts</div>
                    </li>
                @endforeach
            </ol>

            <div class="mt-6 text-xs text-gray-500">Storage: {{ $storageUsage }}</div>
            <div class="mt-2 text-xs text-gray-500">Unique visitors (30d): {{ $uniqueVisitors ?? 0 }}</div>
        </div>
    </div>

    <!-- Top posts by views -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Top Posts (30d)</h3>
        <ol class="list-decimal list-inside space-y-3">
            @foreach($topPosts as $tp)
                <li class="flex justify-between items-center">
                    <div class="text-sm">{{ $tp->title }}</div>
                    <div class="text-sm text-gray-500">{{ $tp->views_count ?? 0 }} views</div>
                </li>
            @endforeach
        </ol>
    </div>

    <!-- Chart.js init -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function() {
            // Posts chart
            const postsData = {
                labels: @json(array_column($postsLast7, 'label')),
                datasets: [{
                    label: 'Posts',
                    data: @json(array_column($postsLast7, 'count')),
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    borderColor: 'rgba(99,102,241,1)',
                    tension: 0.3,
                    fill: true,
                }]
            };

            const postsCtx = document.getElementById('postsChart');
            if (postsCtx) {
                new Chart(postsCtx, { type: 'line', data: postsData, options: { responsive: true, plugins: { legend: { display: false } } } });
            }

            // Users chart
            const usersData = {
                labels: @json(array_column($usersLast30, 'label')),
                datasets: [{
                    label: 'New Users',
                    data: @json(array_column($usersLast30, 'count')),
                    backgroundColor: 'rgba(16,185,129,0.08)',
                    borderColor: 'rgba(16,185,129,1)',
                    tension: 0.25,
                    fill: true,
                }]
            };

            const usersCtx = document.getElementById('usersChart');
            if (usersCtx) {
                new Chart(usersCtx, { type: 'line', data: usersData, options: { responsive: true, plugins: { legend: { display: false } } } });
            }
        })();
    </script>
</div>
