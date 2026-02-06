@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Settings</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your CMS configuration and preferences</p>
        </div>
    </div>

    <!-- Settings Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                    General
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Writing
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Reading
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Discussion
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Media
                </button>
                <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                    Permalinks
                </button>
            </nav>
        </div>

        <!-- General Settings -->
        <div class="p-6">
            <form class="space-y-6">
                <!-- Site Title -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Site Title</label>
                        <input type="text" id="site_title" name="site_title" value="CMS Pro" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="tagline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tagline</label>
                        <input type="text" id="tagline" name="tagline" value="Just another CMS site" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Site Address -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="wordpress_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CMS Address (URL)</label>
                        <input type="url" id="wordpress_url" name="wordpress_url" value="http://localhost:8000" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">The address where your CMS is installed.</p>
                    </div>
                    <div>
                        <label for="site_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Site Address (URL)</label>
                        <input type="url" id="site_url" name="site_url" value="http://localhost:8000" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">The address visitors will use to visit your site.</p>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="admin_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Administration Email Address</label>
                    <input type="email" id="admin_email" name="admin_email" value="admin@example.com" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">This address is used for admin purposes. If you change this, an email will be sent to your new address to confirm it.</p>
                </div>

                <!-- Membership -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Membership</h3>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Anyone can register</span>
                        </label>
                        <div>
                            <label for="default_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New User Default Role</label>
                            <select id="default_role" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option>Subscriber</option>
                                <option>Contributor</option>
                                <option>Author</option>
                                <option>Editor</option>
                                <option>Administrator</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Site Language -->
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Site Language</label>
                    <select id="language" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option>English (United States)</option>
                        <option>Spanish</option>
                        <option>French</option>
                        <option>German</option>
                        <option>Chinese</option>
                    </select>
                </div>

                <!-- Timezone -->
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Timezone</label>
                    <select id="timezone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option>UTC</option>
                        <option>America/New_York</option>
                        <option>America/Chicago</option>
                        <option>America/Denver</option>
                        <option>America/Los_Angeles</option>
                        <option>Europe/London</option>
                        <option>Europe/Paris</option>
                        <option>Asia/Tokyo</option>
                    </select>
                </div>

                <!-- Date Format -->
                <div>
                    <label for="date_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date Format</label>
                    <select id="date_format" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option>F j, Y</option>
                        <option>Y-m-d</option>
                        <option>m/d/Y</option>
                        <option>d/m/Y</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Preview: {{ now()->format('F j, Y') }}</p>
                </div>

                <!-- Time Format -->
                <div>
                    <label for="time_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time Format</label>
                    <select id="time_format" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option>g:i a</option>
                        <option>g:i:s a</option>
                        <option>H:i</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Preview: {{ now()->format('g:i a') }}</p>
                </div>

                <!-- Week Starts On -->
                <div>
                    <label for="week_starts" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Week Starts On</label>
                    <select id="week_starts" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option>Sunday</option>
                        <option>Monday</option>
                    </select>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
