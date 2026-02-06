<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'CMS Laravel'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Un moderno sistema de gestión de contenido'); ?>">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold">C</span>
                    </div>
                    <span class="font-bold text-lg hidden sm:inline">CMS</span>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Home</a>
                    <a href="<?php echo e(route('posts.index')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Blog</a>
                    <a href="/#about" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">About</a>
                    <a href="/#contact" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Contact</a>
                </div>

                <!-- Auth & Mobile Menu -->
                <div class="flex items-center gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check()): ?>
                        <a href="/admin/posts" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                            Dashboard
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button class="text-gray-700 dark:text-gray-300 hover:text-red-600">Logout</button>
                        </form>
                    <?php else: ?>
                        <a href="/login" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 transition">Login</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-gray-700 dark:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-black text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="text-white font-bold mb-4">About CMS</h3>
                    <p class="text-sm text-gray-400">A modern content management system built with Laravel, Livewire and Tailwind CSS.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="hover:text-white transition">Home</a></li>
                        <li><a href="<?php echo e(route('posts.index')); ?>" class="hover:text-white transition">Blog</a></li>
                        <li><a href="/admin/posts" class="hover:text-white transition">Admin</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h3 class="text-white font-bold mb-4">Resources</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://laravel.com" target="_blank" class="hover:text-white transition">Laravel Docs</a></li>
                        <li><a href="https://livewire.laravel.com" target="_blank" class="hover:text-white transition">Livewire</a></li>
                        <li><a href="https://tailwindcss.com" target="_blank" class="hover:text-white transition">Tailwind CSS</a></li>
                    </ul>
                </div>

                <!-- Social -->
                <div>
                    <h3 class="text-white font-bold mb-4">Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 12a4 4 0 100-8 4 4 0 000 8zM12.5 3a.5.5 0 11-1 0 .5.5 0 011 0z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8">
                <div class="flex justify-between items-center text-sm text-gray-400">
                    <p>&copy; 2025 CMS Laravel. All rights reserved.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</html>
<?php /**PATH /home/marcelo/Documents/cms-laravel/resources/views/layouts/app.blade.php ENDPATH**/ ?>