<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

        <title>{{ $heading ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:pt-6 bg-industrial-900">
            <div class="flex flex-col items-center mb-6 sm:mb-8">
                <a href="/">
                    <img src="{{ asset('images/logo.svg') }}" alt="FTHERM Logo" class="h-16 w-16 sm:h-20 sm:w-20">
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-primary-400 mt-3 sm:mt-4">{{ $heading ?? 'FTHERM' }}</h1>
            </div>

            <div class="w-full max-w-md px-4 sm:px-6 py-6 sm:py-8 bg-industrial-800 border border-industrial-700 shadow-xl overflow-hidden rounded-lg sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
