@extends('layouts.app')

@section('title', 'Subscription Plans - Professional CMS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Choose Your Plan</h1>
                <p class="text-xl text-indigo-100">Unlock premium features and take your content to the next level</p>
            </div>
        </div>
    </div>

    <!-- Current Subscription Alert -->
    @if($userSubscription)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-green-800 dark:text-green-200 font-medium">
                                You are currently subscribed to the <strong>{{ $userSubscription->plan->name }}</strong> plan
                            </p>
                            <p class="text-green-600 dark:text-green-400 text-sm">
                                {{ $userSubscription->plan->billing_cycle_text }} • {{ $userSubscription->formatted_price }}
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('subscriptions.cancel', $userSubscription) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your subscription?')">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Cancel Subscription
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Pricing Plans -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($plans as $plan)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden {{ $plan->slug === 'professional' ? 'ring-2 ring-indigo-500' : '' }}">
                    @if($plan->slug === 'professional')
                        <div class="bg-indigo-600 text-white text-center py-2 text-sm font-medium">
                            MOST POPULAR
                        </div>
                    @endif
                    
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $plan->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $plan->description }}</p>
                        
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">${{ number_format($plan->price, 2) }}</span>
                            <span class="text-gray-600 dark:text-gray-400">{{ $plan->billing_cycle_text }}</span>
                        </div>

                        <ul class="space-y-3 mb-8">
                            @foreach($plan->features as $feature)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        @if($userSubscription)
                            @if($userSubscription->plan_id === $plan->id)
                                <button class="w-full px-6 py-3 bg-green-600 text-white rounded-lg cursor-not-allowed" disabled>
                                    Current Plan
                                </button>
                            @else
                                <form action="{{ route('subscriptions.subscribe', $plan) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                        Upgrade to {{ $plan->name }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <form action="{{ route('subscriptions.subscribe', $plan) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                    {{ $plan->price > 0 ? 'Subscribe Now' : 'Get Started' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Features Comparison -->
    <div class="bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">Compare Features</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 text-gray-900 dark:text-white">Feature</th>
                            @foreach($plans as $plan)
                                <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-medium">{{ $plan->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Price</td>
                            @foreach($plans as $plan)
                                <td class="text-center py-3 px-4">
                                    @if($plan->price > 0)
                                        <span class="text-gray-900 dark:text-white font-medium">${{ number_format($plan->price, 2) }}</span>
                                    @else
                                        <span class="text-green-600 dark:text-green-400 font-medium">Free</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Articles</td>
                            @foreach($plans as $plan)
                                <td class="text-center py-3 px-4">
                                    @if($plan->max_articles)
                                        <span class="text-gray-900 dark:text-white">Up to {{ $plan->max_articles }}</span>
                                    @else
                                        <span class="text-green-600 dark:text-green-400">Unlimited</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Storage</td>
                            @foreach($plans as $plan)
                                <td class="text-center py-3 px-4">
                                    @if($plan->max_media_storage)
                                        <span class="text-gray-900 dark:text-white">{{ $plan->max_media_storage }} MB</span>
                                    @else
                                        <span class="text-green-600 dark:text-green-400">Unlimited</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Premium Content</td>
                            @foreach($plans as $plan)
                                <td class="text-center py-3 px-4">
                                    @if($plan->can_access_premium_content)
                                        <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Private Content</td>
                            @foreach($plans as $plan)
                                <td class="text-center py-3 px-4">
                                    @if($plan->can_create_private_content)
                                        <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Advanced Analytics</td>
                            @foreach($plans as $plan)
                                <td class="text-center py-3 px-4">
                                    @if($plan->can_use_advanced_analytics)
                                        <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
