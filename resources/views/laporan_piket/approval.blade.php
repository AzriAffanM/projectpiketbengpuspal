<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Approval Laporan Piket</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-2xl font-semibold text-emerald-900 mb-4">Approval Laporan Piket</h1>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white/95 shadow-xl ring-1 ring-emerald-100 rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-emerald-100">
                    <thead class="bg-emerald-50/60">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Tanggal</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Petugas</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Deskripsi</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Foto</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Waktu Selesai</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Status</th>
                            <th class="px-4 py-2 text-right text-sm font-semibold text-emerald-800">Aksi</th>
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
                                <td class="px-4 py-2 text-sm max-w-xs">
                                    <div class="line-clamp-3">{{ $laporan->deskripsi }}</div>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <a href="{{ Storage::url($laporan->foto_bukti) }}" target="_blank" class="inline-flex items-center px-2 py-1 text-xs rounded-md border border-emerald-200 text-emerald-800 hover:bg-emerald-50">Lihat Foto</a>
                                </td>
                                <td class="px-4 py-2 text-sm">{{ $laporan->waktu_selesai->format('d M Y H:i') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full ring-1 ring-inset
                                        @if ($laporan->status === 'approved') bg-emerald-50 text-emerald-700 ring-emerald-200
                                        @elseif ($laporan->status === 'rejected') bg-red-50 text-red-700 ring-red-200
                                        @else bg-yellow-50 text-yellow-800 ring-yellow-200 @endif">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($laporan->status === 'pending')
                                            <form action="{{ route('laporan-piket.approve', $laporan) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="inline-flex items-center px-3 py-1.5 text-xs rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Approve</button>
                                            </form>
                                            <form action="{{ route('laporan-piket.reject', $laporan) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="inline-flex items-center px-3 py-1.5 text-xs rounded-lg bg-red-600 text-white hover:bg-red-700">Reject</button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">Sudah diproses</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500 text-sm">Belum ada laporan piket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $laporans->links() }}</div>
        </div>
    </div>
</x-app-layout>
