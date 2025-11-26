<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Piket (Admin)</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-2xl font-semibold text-emerald-900 mb-4">Laporan Piket Terverifikasi</h1>

            <div class="bg-white/95 shadow-xl ring-1 ring-emerald-100 rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-emerald-100">
                    <thead class="bg-emerald-50/60">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Tanggal</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Petugas</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Foto Bukti</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Deskripsi</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Waktu Selesai</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-100">
                        @forelse ($laporans as $laporan)
                            <tr class="hover:bg-emerald-50/40">
                                <td class="px-4 py-2 text-sm">{{ \Illuminate\Support\Carbon::parse($laporan->jadwalJaga->tanggal_jaga)->format('d M Y') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    {{ $laporan->jadwalJaga->petugas->nama ?? '-' }}<br>
                                    <span class="text-xs text-gray-500">{{ $laporan->jadwalJaga->petugas->nrp ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <a href="{{ Storage::url($laporan->foto_bukti) }}" target="_blank" class="inline-flex items-center px-2 py-1 text-xs rounded-md border border-emerald-200 text-emerald-800 hover:bg-emerald-50">Lihat Foto</a>
                                </td>
                                <td class="px-4 py-2 text-sm max-w-xs">
                                    <div class="line-clamp-3">{{ $laporan->deskripsi }}</div>
                                </td>
                                <td class="px-4 py-2 text-sm">{{ $laporan->waktu_selesai->format('d M Y H:i') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full ring-1 ring-inset bg-emerald-50 text-emerald-700 ring-emerald-200">Approved</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500 text-sm">Belum ada laporan piket yang disetujui.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $laporans->links() }}</div>
        </div>
    </div>
</x-app-layout>
