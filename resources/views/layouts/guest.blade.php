<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

        <title>{{ $heading ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-10px);
                }
            }
            
            .animate-fade-in-up {
                animation: fadeInUp 0.6s ease-out;
            }
            
            .animate-float {
                animation: float 3s ease-in-out infinite;
            }
            
            /* Disable tap highlight on mobile */
            * {
                -webkit-tap-highlight-color: transparent;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:pt-6 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl opacity-20 animate-float"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl opacity-20 animate-float" style="animation-delay: 1s;"></div>
            </div>

            <!-- Logo Section -->
            <div class="flex flex-col items-center mb-8 sm:mb-10 relative z-10 animate-fade-in-up">
                <a href="/" class="group">
                    <div class="bg-white rounded-3xl p-4 shadow-2xl group-hover:shadow-3xl transition-all group-hover:scale-105 mb-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-16 w-16 sm:h-20 sm:w-20">
                    </div>
                </a>
                @if(str_contains($heading ?? '', 'Worker'))
                <p class="text-primary-100 text-sm mt-2">Worker Portal</p>
                @endif
            </div>

            <!-- Card -->
            <div class="w-full max-w-md px-6 sm:px-8 py-8 sm:py-10 bg-white backdrop-blur-xl border border-gray-100 shadow-2xl overflow-hidden rounded-2xl sm:rounded-3xl relative z-10 animate-fade-in-up" style="animation-delay: 0.2s;">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-white/80 relative z-10 animate-fade-in-up" style="animation-delay: 0.4s;">
                <p class="drop-shadow">&copy; {{ date('Y') }} FTHERM. All rights reserved.</p>
            </div>
        </div>
        
        <script>
            // Prevent zoom on input focus (iOS)
            document.addEventListener('touchstart', function() {}, {passive: true});
            
            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';
        </script>
    </body>
</html>
