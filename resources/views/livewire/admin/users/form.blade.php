<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ $userId ? 'Edit User' : 'Create New User' }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                {{ $userId ? 'Update user details and roles' : 'Add a new user to the system' }}
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session('message'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-green-800 dark:text-green-200">{{ session('message') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-6">
            <form wire:submit="save" class="space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Name</label>
                    <input
                        wire:model="name"
                        type="text"
                        placeholder="Enter user name"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Email</label>
                    <input
                        wire:model="email"
                        type="email"
                        placeholder="Enter user email"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                        Password {{ $userId ? '(leave blank to keep current)' : '' }}
                    </label>
                    <input
                        wire:model="password"
                        type="password"
                        placeholder="Enter password"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Confirm Password</label>
                    <input
                        wire:model="passwordConfirmation"
                        type="password"
                        placeholder="Confirm password"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('passwordConfirmation')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Roles -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-3">Roles</label>
                    <div class="space-y-2">
                        @foreach ($roles as $role)
                            <label class="flex items-center">
                                <input
                                    wire:model="selectedRoles"
                                    type="checkbox"
                                    value="{{ $role->id }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-gray-700 dark:text-gray-300">
                                    {{ $role->display_name }}
                                    <span class="text-xs text-gray-500">{{ $role->description }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('selectedRoles')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition"
                    >
                        {{ $userId ? 'Update User' : 'Create User' }}
                    </button>
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="px-6 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
