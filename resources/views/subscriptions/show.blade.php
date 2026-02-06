@extends('layouts.app')

@section('title', $plan->name . ' Plan - Professional CMS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">{{ $plan->name }} Plan</h1>
                <p class="text-xl text-indigo-100 mb-8">{{ $plan->description }}</p>
                <div class="flex justify-center items-center space-x-4">
                    <span class="text-5xl font-bold">${{ number_format($plan->price, 2) }}</span>
                    <span class="text-xl text-indigo-100">{{ $plan->billing_cycle_text }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Plan Details -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Features -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">What's Included</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($plan->features as $feature)
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Limits & Quotas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Usage Limits</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-700 dark:text-gray-300">Articles</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                @if($plan->max_articles)
                                    Up to {{ $plan->max_articles }} articles
                                @else
                                    Unlimited articles
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-700 dark:text-gray-300">Media Storage</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                @if($plan->max_media_storage)
                                    {{ $plan->max_media_storage }} MB
                                @else
                                    Unlimited storage
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-700 dark:text-gray-300">Premium Content Access</span>
                            <span class="font-medium {{ $plan->can_access_premium_content ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ $plan->can_access_premium_content ? 'Included' : 'Not Available' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-700 dark:text-gray-300">Private Content Creation</span>
                            <span class="font-medium {{ $plan->can_create_private_content ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ $plan->can_create_private_content ? 'Included' : 'Not Available' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-700 dark:text-gray-300">Advanced Analytics</span>
                            <span class="font-medium {{ $plan->can_use_advanced_analytics ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ $plan->can_use_advanced_analytics ? 'Included' : 'Not Available' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Revenue Sharing Info -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Revenue Sharing</h2>
                    <div class="text-gray-700 dark:text-gray-300">
                        <p class="mb-4">As a content creator, you'll earn revenue from your content with transparent commission structure:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">85-95%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">You Keep</div>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-2">5-15%</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Platform Fee</div>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            Commission rates vary by plan type. Premium plans have lower platform fees.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Subscribe Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 sticky top-6">
                    @if($userSubscription && $userSubscription->plan_id === $plan->id)
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Current Plan</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">You're already subscribed to this plan</p>
                            <div class="space-y-2 text-left">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Status:</span>
                                    <span class="font-medium text-green-600 dark:text-green-400">Active</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Started:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $userSubscription->starts_at->format('M j, Y') }}</span>
                                </div>
                                @if($userSubscription->ends_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Renews:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $userSubscription->ends_at->format('M j, Y') }}</span>
                                    </div>
                                @endif
                            </div>
                            <form action="{{ route('subscriptions.cancel', $userSubscription) }}" method="POST" class="mt-6" onsubmit="return confirm('Are you sure you want to cancel your subscription?')">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Cancel Subscription
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Subscribe Now</h3>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                ${{ number_format($plan->price, 2) }}
                                <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/{{ $plan->billing_cycle }}</span>
                            </div>
                            
                            @if($userSubscription)
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                        You're currently on the {{ $userSubscription->plan->name }} plan. Upgrading will take effect immediately.
                                    </p>
                                </div>
                            @endif

                            <!-- Payment Method Selection -->
                            <form action="{{ route('subscriptions.subscribe', $plan) }}" method="POST" id="subscribeForm">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <input type="radio" name="payment_method" value="paypal" checked class="mr-3">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944 2.419c.12-.548.638-.919 1.2-.919h7.87c2.556 0 4.359 1.055 5.485 2.586.893 1.212 1.323 2.75 1.323 4.387 0 1.637-.43 3.175-1.323 4.387-1.126 1.531-2.929 2.586-5.485 2.586H8.534l-.632 2.895a.641.641 0 0 1-.626.498z"/>
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">PayPal</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <input type="radio" name="payment_method" value="bitcoin" class="mr-3">
                                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.577 12.309l.894-4.024c1.329.295 2.144.295 2.144.295 1.329 0 1.933-.594 1.933-1.485 0-1.189-1.034-1.485-2.66-1.485H12.48l-.894 4.024h-1.034l.894-4.024h-1.034l.894-4.024h1.034l-.894 4.024h1.034l.894-4.024h1.034l-.894 4.024h1.034l-.894 4.024h-1.034l-.894 4.024h-1.034l.894-4.024h-1.034zm-1.034 4.024l.894-4.024h1.034l-.894 4.024h-1.034z"/>
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">Bitcoin</span>
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                                    {{ $plan->price > 0 ? 'Subscribe Now' : 'Get Started Free' }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Wallet Info -->
                @if(auth()->check())
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Wallet</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Current Balance:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    ${{ number_format(auth()->user()->wallet?->balance ?? 0, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Earned:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    ${{ number_format(auth()->user()->wallet?->total_earned ?? 0, 2) }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('wallet.index') }}" class="block w-full mt-4 text-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            View Wallet
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
