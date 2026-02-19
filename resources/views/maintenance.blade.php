<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance Mode - FTHERM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes reveal { from { opacity:0; transform:translateY(32px) scale(0.97) } to { opacity:1; transform:translateY(0) scale(1) } }
        @keyframes spin-slow { from { transform: rotate(0deg) } to { transform: rotate(360deg) } }
        @keyframes bar { 0%,100% { width:30% } 50% { width:70% } }
        .anim-reveal { animation: reveal .7s cubic-bezier(.22,1,.36,1) both }
        .d1 { animation-delay:.1s } .d2 { animation-delay:.2s } .d3 { animation-delay:.3s } .d4 { animation-delay:.4s } .d5 { animation-delay:.5s }
        .spin-slow { animation: spin-slow 20s linear infinite }
        .bar-move { animation: bar 2.5s ease-in-out infinite }
    </style>
</head>
<body class="bg-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Subtle grid background -->
    <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(circle, #e2e8f0 1px, transparent 1px); background-size: 32px 32px; opacity: 0.5"></div>

    <!-- Floating accent shapes -->
    <div class="absolute top-10 right-10 sm:top-20 sm:right-20 w-64 h-64 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 opacity-40 blur-2xl"></div>
    <div class="absolute bottom-10 left-10 sm:bottom-20 sm:left-20 w-48 h-48 rounded-full bg-gradient-to-tr from-secondary-100 to-secondary-200 opacity-30 blur-2xl"></div>

    <!-- Spinning decorative ring -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] sm:w-[600px] sm:h-[600px] pointer-events-none">
        <div class="w-full h-full rounded-full border border-dashed border-light-300 opacity-30 spin-slow"></div>
    </div>

    <!-- Main card -->
    <div class="relative z-10 w-full max-w-lg mx-4">
        <div class="bg-white/80 backdrop-blur-xl border border-light-200 rounded-3xl shadow-2xl p-8 sm:p-12 text-center">

            <!-- Logo -->
            <div class="anim-reveal mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-primary-600 to-primary-800 shadow-xl shadow-primary-500/25 ring-4 ring-primary-100">
                    <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="w-12 h-12 sm:w-14 sm:h-14" />
                </div>
            </div>

            <!-- Badge -->
            <div class="anim-reveal d1 mb-5">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-50 border border-primary-100 text-primary-700 text-xs font-bold uppercase tracking-widest">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
                    </span>
                    Održavanje u toku
                </span>
            </div>

            <!-- Heading -->
            <h1 class="anim-reveal d2 text-3xl sm:text-4xl font-extrabold text-industrial-900 tracking-tight mb-3">
                Sajt je u izradi
            </h1>

            <!-- Description -->
            <p class="anim-reveal d3 text-industrial-500 text-sm sm:text-base leading-relaxed max-w-sm mx-auto mb-8">
                Trenutno radimo na unaprjeđenju našeg sistema. Molimo vas da navratite kasnije.
            </p>

            <!-- Progress bar -->
            <div class="anim-reveal d3 mb-8">
                <div class="h-1.5 bg-light-200 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-primary-500 via-primary-400 to-primary-600 rounded-full bar-move"></div>
                </div>
            </div>

            <!-- Divider -->
            <div class="anim-reveal d4 border-t border-light-200 pt-6 mb-1">
                <p class="text-xs text-industrial-400 font-medium mb-4">U međuvremenu, kontaktirajte nas:</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="mailto:farkas.tibor@ftherm.rs"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-light-100 hover:bg-primary-50 border border-light-200 hover:border-primary-200 text-industrial-600 hover:text-primary-700 transition-all text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        farkas.tibor@ftherm.rs
                    </a>
                    <a href="tel:+381641391360"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-light-100 hover:bg-primary-50 border border-light-200 hover:border-primary-200 text-industrial-600 hover:text-primary-700 transition-all text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        064 139 1360
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer outside card -->
        <p class="anim-reveal d5 text-center text-xs text-industrial-400 mt-6">
            &copy; {{ date('Y') }} FTHERM. Sva prava zadržana.
        </p>
    </div>
</body>
</html>
