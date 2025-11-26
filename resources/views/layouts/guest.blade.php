<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bengpuspal Piket Jaga Malam') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center bg-emerald-900">
            <div class="w-full max-w-md px-6">
                <div class="bg-white/95 shadow-xl ring-1 ring-black/10 rounded-xl overflow-hidden">
                    <div class="px-6 py-6">
                        {{ $slot }}
                    </div>
                </div>

                <p class="mt-6 text-center text-xs text-emerald-100">&copy; {{ date('Y') }} Bengpuspal. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>

