@extends('layouts.admin')

@section('title', 'Comments')

@section('content')
<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Comments</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Manage and moderate user comments</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Search comments..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Mark All as Read
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Comments</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">142</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Approved</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">128</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">3</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Spam</p>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400">11</p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">All Comments</h2>
                <div class="flex items-center gap-4">
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <option>All Comments</option>
                        <option>Approved</option>
                        <option>Pending</option>
                        <option>Spam</option>
                        <option>Trash</option>
                    </select>
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <option>All Dates</option>
                        <option>Today</option>
                        <option>This Week</option>
                        <option>This Month</option>
                        <option>This Year</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <!-- Pending Comment -->
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                        <span class="text-yellow-600 dark:text-yellow-400 font-semibold">JD</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white">John Doe</h3>
                                    <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 text-xs rounded-full">Pending</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">on</span>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Getting Started with Laravel</a>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">john.doe@example.com • 2 hours ago</p>
                                <p class="text-gray-700 dark:text-gray-300 mb-3">Great article! This really helped me understand the basics of Laravel. I've been struggling with routing and this explanation made it so clear.</p>
                                <div class="flex items-center gap-2">
                                    <button class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">Approve</button>
                                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Reply</button>
                                    <button class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-sm rounded hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">Spam</button>
                                    <button class="px-3 py-1 text-gray-600 dark:text-gray-400 text-sm rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Trash</button>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <button class="hover:text-gray-700 dark:hover:text-gray-300">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approved Comment -->
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <span class="text-green-600 dark:text-green-400 font-semibold">SJ</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white">Sarah Johnson</h3>
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs rounded-full">Approved</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">on</span>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Best Practices for API Design</a>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">sarah.j@example.com • 5 hours ago</p>
                                <p class="text-gray-700 dark:text-gray-300 mb-3">This is exactly what I was looking for! The RESTful principles explained here are spot on. Would love to see a follow-up article on GraphQL implementation.</p>
                                <div class="flex items-center gap-2">
                                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Reply</button>
                                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Edit</button>
                                    <button class="px-3 py-1 text-red-600 dark:text-red-400 text-sm rounded hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">Trash</button>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <button class="hover:text-gray-700 dark:hover:text-gray-300">Unapprove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spam Comment -->
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors opacity-75">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <span class="text-red-600 dark:text-red-400 font-semibold">??</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white">Spam Bot</h3>
                                    <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs rounded-full">Spam</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">on</span>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Contact Us</a>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">spam@fake.com • 1 day ago</p>
                                <p class="text-gray-700 dark:text-gray-300 mb-3 line-through">Check out my amazing deals!!! Click here for cheap stuff!!!</p>
                                <div class="flex items-center gap-2">
                                    <button class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">Not Spam</button>
                                    <button class="px-3 py-1 text-red-600 dark:text-red-400 text-sm rounded hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">Delete Forever</button>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <button class="hover:text-gray-700 dark:hover:text-gray-300">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- More Comments -->
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 dark:text-blue-400 font-semibold">MC</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white">Mike Chen</h3>
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs rounded-full">Approved</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">on</span>
                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Database Optimization Tips</a>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">mike.chen@example.com • 2 days ago</p>
                                <p class="text-gray-700 dark:text-gray-300 mb-3">These optimization techniques really work! I implemented the indexing strategy and saw a 300% improvement in query performance.</p>
                                <div class="flex items-center gap-2">
                                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Reply</button>
                                    <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Edit</button>
                                    <button class="px-3 py-1 text-red-600 dark:text-red-400 text-sm rounded hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">Trash</button>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <button class="hover:text-gray-700 dark:hover:text-gray-300">Unapprove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">4</span> of <span class="font-medium">142</span> results
                </p>
                <div class="flex items-center gap-2">
                    <button class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        Previous
                    </button>
                    <button class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        1
                    </button>
                    <button class="px-3 py-2 border border-blue-500 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                        2
                    </button>
                    <button class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        3
                    </button>
                    <span class="px-3 py-2 text-gray-500 dark:text-gray-400">...</span>
                    <button class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        36
                    </button>
                    <button class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
