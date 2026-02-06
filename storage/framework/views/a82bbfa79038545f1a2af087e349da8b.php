<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Server Error
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Something went wrong. Please try again later.
            </p>
        </div>
        
        <div class="mt-8">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-800">
                                Temporary Issue
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Our team has been notified and is working on a fix.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-800">
                                Need Help?
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Contact support if the problem persists.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="<?php echo e(route('home')); ?>" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/marcelo/Documents/cms-laravel/resources/views/errors/500.blade.php ENDPATH**/ ?>