<x-app-layout>
    <!-- Hero header with dark green theme -->
    <div class="bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700">
        <div class="max-w-7xl mx-auto px-6 py-8 text-emerald-50">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" alt="Bengpuspal" class="w-10 h-10 opacity-90 object-contain">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Sistem Piket Bengpuspal</h1>
                    <p class="text-emerald-200 text-sm">Piket jaga malam terjadwal dan otomatis</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content cards -->
    <div class="mt-6 pb-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white/95 shadow-xl ring-1 ring-emerald-100 sm:rounded-xl">
                <div class="p-6 sm:p-8">
                    <div class="text-lg text-emerald-900">Halo, <span class="font-semibold">{{ auth()->user()->name }}</span></div>

                    <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 rounded-lg border border-emerald-200 bg-emerald-50">
                            <div class="text-xs uppercase tracking-wide text-emerald-700">Tanggal Jaga</div>
                            <div class="mt-1 text-xl font-semibold text-emerald-900">{{ isset($jadwalHariIni) ? \Illuminate\Support\Carbon::parse($jadwalHariIni->tanggal_jaga)->format('d M Y') : '-' }}</div>
                        </div>
                        <div class="p-4 rounded-lg border border-emerald-200 bg-emerald-50">
                            <div class="text-xs uppercase tracking-wide text-emerald-700">Petugas</div>
                            <div class="mt-1 text-xl font-semibold text-emerald-900">{{ $jadwalHariIni->petugas->nama ?? '-' }}</div>
                        </div>
                        <div class="p-4 rounded-lg border border-emerald-200 bg-emerald-50">
                            <div class="text-xs uppercase tracking-wide text-emerald-700">Status</div>
                            <div class="mt-1">
                                @php $isOn = ($status === 'Sedang Bertugas'); @endphp
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-sm font-medium {{ $isOn ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-700' }}">
                                    <span class="h-2 w-2 rounded-full {{ $isOn ? 'bg-emerald-200' : 'bg-slate-500' }}"></span>
                                    {{ $status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if (auth()->user() && auth()->user()->role === 'admin')
                        @php
                            $totalPetugas = \App\Models\Petugas::count();
                            $pendingLaporan = \App\Models\LaporanPiket::where('status', 'pending')->count();
                        @endphp

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg border border-emerald-200 bg-emerald-50">
                                <div class="text-xs uppercase tracking-wide text-emerald-700">Ringkasan Admin</div>
                                <dl class="mt-3 space-y-1 text-sm text-emerald-900">
                                    <div class="flex items-center justify-between">
                                        <dt>Jumlah Petugas</dt>
                                        <dd class="font-semibold">{{ $totalPetugas }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <dt>Laporan Menunggu Approval</dt>
                                        <dd class="font-semibold">{{ $pendingLaporan }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="p-4 rounded-lg border border-emerald-200 bg-emerald-50 flex flex-col gap-2">
                                <div class="text-xs uppercase tracking-wide text-emerald-700">Aksi Cepat Admin</div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <a href="{{ route('laporan-piket.approval') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-emerald-700 text-white text-sm hover:bg-emerald-800">Kelola Approval Laporan</a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user() && auth()->user()->role === 'petugas')
                    <div class="mt-6">
                        <a href="{{ route('jadwal-jaga.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-700 text-white hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M3 6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75v10.5A2.25 2.25 0 0118.75 19.5H5.25A2.25 2.25 0 013 17.25V6.75zM7.5 8.25A.75.75 0 006.75 9v.75c0 .414.336.75.75.75h.75a.75.75 0 00.75-.75V9a.75.75 0 00-.75-.75H7.5zM6.75 12a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75V12zm3.75-3.75a.75.75 0 01.75-.75h5.25a.75.75 0 01.75.75V9a.75.75 0 01-.75.75H11.25A.75.75 0 0110.5 9V8.25zM11.25 12a.75.75 0 01.75-.75h5.25a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12z"/></svg>
                            Lihat Jadwal Piket
                        </a>
                    </div>

                    <!-- Daftar Petugas (hanya petugas) -->
                    <div class="mt-10">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-emerald-900">Daftar Petugas</h2>
                        </div>
                        <div class="mt-3 overflow-x-auto border border-emerald-200 rounded-lg">
                            <table class="min-w-full divide-y divide-emerald-200">
                                <thead class="bg-emerald-50">
                                    <tr class="text-left text-sm text-emerald-700">
                                        <th class="px-3 py-2">#</th>
                                        <th class="px-3 py-2">Nama</th>
                                        <th class="px-3 py-2">Pangkat</th>
                                        <th class="px-3 py-2">Jabatan</th>
                                        <th class="px-3 py-2">No. Telepon</th>
                                        <th class="px-3 py-2">Urutan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-emerald-100 bg-white">
                                    @forelse($daftarPetugas as $i => $p)
                                        <tr class="text-sm text-emerald-900">
                                            <td class="px-3 py-2">{{ $i+1 }}</td>
                                            <td class="px-3 py-2 font-medium">{{ $p->nama }}</td>
                                            <td class="px-3 py-2">{{ $p->pangkat }}</td>
                                            <td class="px-3 py-2">{{ $p->jabatan }}</td>
                                            <td class="px-3 py-2">{{ $p->nomor_telepon }}</td>
                                            <td class="px-3 py-2">{{ $p->urutan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-3 py-4 text-center text-sm text-emerald-700">Belum ada petugas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

