<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches) }" :class="{ 'dark': darkMode }">
    <head>
        @include('partials.head')
        <style>
            .auth-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .dark .auth-gradient {
                background: linear-gradient(135deg, #1e3a8a 0%, #312e81 50%, #1e1b4b 100%);
            }
            .glass-morphism {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.18);
            }
            .dark .glass-morphism {
                background: rgba(30, 41, 59, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
            .floating-shapes {
                position: absolute;
                border-radius: 50%;
                filter: blur(40px);
                opacity: 0.6;
                animation: float 6s ease-in-out infinite;
            }
            .shape-1 {
                width: 300px;
                height: 300px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                top: -150px;
                right: -150px;
                animation-delay: 0s;
            }
            .shape-2 {
                width: 200px;
                height: 200px;
                background: linear-gradient(135deg, #f093fb, #f5576c);
                bottom: -100px;
                left: -100px;
                animation-delay: 2s;
            }
            .shape-3 {
                width: 150px;
                height: 150px;
                background: linear-gradient(135deg, #4facfe, #00f2fe);
                top: 50%;
                left: -75px;
                animation-delay: 4s;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }
            .auth-input {
                @apply w-full px-4 py-3 rounded-xl border border-gray-200 bg-white/50 backdrop-blur-sm text-gray-900 placeholder-gray-500 transition-all duration-200 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800/50 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-400 dark:focus:bg-gray-800 dark:focus:ring-blue-400/20;
            }
            .auth-button {
                @apply w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-xl shadow-lg shadow-blue-500/25 transition-all duration-200 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500/50 active:scale-[0.98];
            }
        </style>
    </head>
    <body class="min-h-screen antialiased">
        <div class="auth-gradient min-h-screen relative overflow-hidden">
            <!-- Floating Background Shapes -->
            <div class="floating-shapes shape-1"></div>
            <div class="floating-shapes shape-2"></div>
            <div class="floating-shapes shape-3"></div>
            
            <!-- Main Content -->
            <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
                <div class="w-full max-w-md">
                    <!-- Logo/Brand Section -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl shadow-xl mb-4">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-white mb-2">CMS Pro</h1>
                        <p class="text-blue-100 text-sm">Content Management System</p>
                    </div>

                    <!-- Auth Card -->
                    <div class="glass-morphism rounded-2xl shadow-2xl p-8">
                        {{ $slot }}
                    </div>

                    <!-- Footer Links -->
                    <div class="text-center mt-8">
                        <p class="text-blue-100 text-sm">
                            © {{ date('Y') }} CMS Pro. All rights reserved.
                        </p>
                        <div class="mt-2 space-x-4">
                            <a href="#" class="text-blue-200 hover:text-white text-sm transition-colors">Privacy</a>
                            <a href="#" class="text-blue-200 hover:text-white text-sm transition-colors">Terms</a>
                            <a href="#" class="text-blue-200 hover:text-white text-sm transition-colors">Support</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dark Mode Toggle -->
            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                    class="fixed top-4 right-4 z-20 p-3 bg-white/20 backdrop-blur-sm rounded-xl text-white hover:bg-white/30 transition-colors">
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </button>
        </div>
        
        @fluxScripts
    </body>
</html>
