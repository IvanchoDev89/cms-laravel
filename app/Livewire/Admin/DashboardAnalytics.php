<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DashboardAnalytics extends Component
{
    public $postsLast7 = [];
    public $usersLast30 = [];
    public $overview = [];
    public $recentPosts = [];
    public $topAuthors = [];
    public $storageUsage = 0;
    public $topPosts = [];
    public $uniqueVisitors = 0;

    public function mount()
    {
        // Only load analytics for admin users; non-admins will see the dashboard without analytics data.
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            $this->overview = [];
            $this->postsLast7 = [];
            $this->usersLast30 = [];
            $this->recentPosts = [];
            $this->topAuthors = [];
            $this->topPosts = [];
            $this->uniqueVisitors = 0;
            $this->storageUsage = 0;
            return;
        }

        $this->loadOverview();
        $this->loadPostsLast7();
        $this->loadUsersLast30();
        $this->loadRecentPosts();
        $this->loadTopAuthors();
        $this->loadTopPosts();
        $this->loadUniqueVisitors();
        $this->loadStorageUsage();
    }

    protected function loadOverview()
    {
        $totalPosts = Post::count();
        $published = Post::where('status', 'published')->count();
        $drafts = Post::where('status', 'draft')->count();
        $totalUsers = User::count();
        $media = Media::count();

        $this->overview = compact('totalPosts', 'published', 'drafts', 'totalUsers', 'media');
    }

    protected function loadPostsLast7()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('M d');
            $count = Post::whereDate('published_at', $day)->where('status', 'published')->count();
            $data[] = ['label' => $label, 'count' => $count];
        }
        $this->postsLast7 = $data;
    }

    protected function loadUsersLast30()
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('M d');
            $count = User::whereDate('created_at', $day)->count();
            $data[] = ['label' => $label, 'count' => $count];
        }
        $this->usersLast30 = $data;
    }

    protected function loadRecentPosts()
    {
        $this->recentPosts = Post::latest()->take(6)->get(['id','title','slug','status','published_at']);
    }

    protected function loadTopAuthors()
    {
        $this->topAuthors = User::withCount(['posts'])->orderByDesc('posts_count')->take(5)->get(['id','name']);
    }

    protected function loadTopPosts()
    {
        // Top posts by views in the last 30 days
        $this->topPosts = Post::withCount(['views as views_count' => function ($q) {
            $q->where('created_at', '>=', now()->subDays(30));
        }])->orderByDesc('views_count')->take(6)->get(['id','title','slug']);
    }

    protected function loadUniqueVisitors()
    {
        // Unique visitor IPs in last 30 days
        $this->uniqueVisitors = \App\Models\PostView::where('created_at', '>=', now()->subDays(30))
            ->distinct('ip')
            ->count('ip');
    }

    protected function loadStorageUsage()
    {
        $files = Storage::disk('public')->allFiles();
        $size = 0;
        foreach ($files as $file) {
            try {
                $size += Storage::disk('public')->size($file);
            } catch (\Exception $e) {
                // ignore missing files
            }
        }
        $this->storageUsage = $size; // bytes
    }

    protected function humanFilesize($bytes, $decimals = 2)
    {
        $sz = ['B','KB','MB','GB','TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f %s", $bytes / pow(1024, $factor), $sz[$factor]);
    }

    public function render()
    {
        return view('livewire.admin.dashboard-analytics', [
            'overview' => $this->overview,
            'postsLast7' => $this->postsLast7,
            'usersLast30' => $this->usersLast30,
            'recentPosts' => $this->recentPosts,
            'topAuthors' => $this->topAuthors,
            'topPosts' => $this->topPosts,
            'uniqueVisitors' => $this->uniqueVisitors,
            'storageUsage' => $this->humanFilesize($this->storageUsage),
        ]);
    }
}
