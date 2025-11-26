<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak]{display:none!important}</style>
    </head>
    <body class="font-sans antialiased" x-data="{ sidebarOpen: false }">
        <!-- Mobile header -->
        <div class="sm:hidden sticky top-0 z-40 bg-emerald-900 text-emerald-100">
            <div class="h-14 flex items-center justify-between px-4">
                <button class="p-2 -ml-2" @click="sidebarOpen = true" aria-label="Open menu">
                    <!-- Hamburger icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" class="w-7 h-7 object-contain" alt="Bengpuspal">
                    <span class="font-semibold">Bengpuspal</span>
                </a>
                <span class="w-6 h-6"></span>
            </div>
        </div>

        <!-- Mobile sidebar (off-canvas) -->
        <div class="sm:hidden" x-show="sidebarOpen" x-cloak>
            <div class="fixed inset-0 z-40 flex">
                <div class="fixed inset-0 bg-black/50" @click="sidebarOpen = false"></div>
                <aside class="relative z-50 w-64 bg-emerald-900 text-emerald-100 h-full shadow-xl transform transition-transform duration-200 ease-out">
                    <!-- Brand -->
                    <div class="h-16 flex items-center gap-3 px-4 border-b border-emerald-800">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                            <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" class="w-8 h-8 object-contain" alt="Bengpuspal">
                            <span class="font-semibold">Bengpuspal</span>
                        </a>
                        <button class="ml-auto p-2 text-emerald-100" @click="sidebarOpen = false" aria-label="Close menu">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Nav links (mobile copy) -->
                    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                        @php
                            $link = function($href, $label, $active) {
                                $base = 'group flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium';
                                $activeClass = $active ? ' bg-emerald-800 text-white' : ' text-emerald-200 hover:bg-emerald-800 hover:text-white';
                                return "<a href='{$href}' class='{$base}{$activeClass}'>{$label}</a>";
                            };
                        @endphp

                        @if (auth()->check() && auth()->user()->role === 'petugas')
                            {!! $link(route('dashboard'), 'Dashboard', request()->routeIs('dashboard')) !!}
                            {!! $link(route('jadwal-jaga.index'), 'Jadwal Piket', request()->routeIs('jadwal-jaga.*')) !!}
                            {!! $link(route('laporan-piket.index'), 'Laporan Piket', request()->routeIs('laporan-piket.index')) !!}
                            {!! $link(route('petugas.index'), 'Petugas', request()->routeIs('petugas.index') || request()->routeIs('petugas.show') || request()->routeIs('petugas.edit')) !!}
                            {!! $link(route('petugas.create'), 'Tambah Petugas', request()->routeIs('petugas.create')) !!}
                        @elseif (auth()->check() && auth()->user()->role === 'admin')
                            {!! $link(route('dashboard'), 'Dashboard', request()->routeIs('dashboard')) !!}
                            {!! $link(route('laporan-piket.approval'), 'Approval Laporan', request()->routeIs('laporan-piket.approval')) !!}
                        @endif
                    </nav>

                    <!-- Footer / Profile -->
                    <div class="border-t border-emerald-800 p-3">
                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-emerald-300 truncate">{{ Auth::user()->email }}</div>
                        <div class="mt-3 flex items-center gap-2">
                            <a href="{{ route('profile.edit') }}" class="text-xs text-emerald-200 hover:text-white">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                                @csrf
                                <button class="text-xs text-emerald-200 hover:text-white">Keluar</button>
                            </form>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Main content -->
            <div class="flex-1 min-w-0">
                <!-- Optional page heading slot -->
                @isset($header)
                    <header class="bg-white border-b">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>


