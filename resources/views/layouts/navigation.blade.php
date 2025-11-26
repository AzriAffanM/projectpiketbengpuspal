<aside class="w-64 bg-emerald-900 text-emerald-100 min-h-screen hidden sm:flex flex-col">
    <!-- Brand -->
    <div class="h-16 flex items-center gap-3 px-4 border-b border-emerald-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" class="w-8 h-8 object-contain" alt="Bengpuspal">
            <span class="font-semibold">Bengpuspal</span>
        </a>
    </div>

    <!-- Nav links -->
    <nav class="flex-1 px-3 py-4 space-y-1">
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
            @php
                $pendingLaporanCount = \App\Models\LaporanPiket::where('status', 'pending')->count();
            @endphp
            {!! $link(route('dashboard'), 'Dashboard', request()->routeIs('dashboard')) !!}
            <div class="flex items-center justify-between">
                {!! $link(route('laporan-piket.approval'), 'Approval Laporan', request()->routeIs('laporan-piket.approval')) !!}
                @if ($pendingLaporanCount > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full bg-red-500 text-white">{{ $pendingLaporanCount }}</span>
                @endif
            </div>
        @endif
    </nav>

    <!-- Footer / Profile -->
    <div class="mt-auto border-t border-emerald-800 p-3">
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
