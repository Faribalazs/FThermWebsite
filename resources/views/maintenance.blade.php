<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance Mode - FTHERM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-industrial-900 text-white font-sans antialiased flex flex-col items-center justify-center min-h-screen">
    <div class="text-center px-4">
        <x-application-logo class="w-24 h-24 fill-current text-primary-500 mx-auto mb-8" />
        
        <h1 class="text-4xl font-bold text-primary-400 mb-4">Sajt je u izradi</h1>
        
        <p class="text-xl text-gray-300 max-w-2xl mx-auto mb-8">
            Trenutno radimo na unaprjeđenju našeg sistema. Molimo vas da navratite kasnije.
        </p>

        <div class="flex justify-center space-x-2">
            <div class="w-3 h-3 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 0s"></div>
            <div class="w-3 h-3 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
            <div class="w-3 h-3 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
        </div>
        
        <p class="mt-12 text-sm text-gray-500">
            &copy; {{ date('Y') }} FTHERM. Sva prava zadržana.
        </p>
    </div>
</body>
</html>
