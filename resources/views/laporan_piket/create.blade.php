<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Piket</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-6">
            <h1 class="text-2xl font-semibold text-emerald-900 mb-4">Form Laporan Piket</h1>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white/95 shadow-xl ring-1 ring-emerald-100 rounded-xl p-6 space-y-4">
                <div>
                    <div class="text-sm text-gray-500">Petugas</div>
                    <div class="font-semibold text-gray-900">{{ $jadwal->petugas->nama ?? '-' }} ({{ $jadwal->petugas->nrp ?? '-' }})</div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <div class="text-gray-500">Tanggal Piket</div>
                        <div class="font-medium text-gray-900">{{ \Illuminate\Support\Carbon::parse($jadwal->tanggal_jaga)->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Shift</div>
                        <div class="font-medium text-gray-900">{{ substr($jadwal->shift_mulai,0,5) }} - {{ substr($jadwal->shift_selesai,0,5) }}</div>
                    </div>
                </div>

                <form action="{{ route('laporan-piket.store-from-jadwal', $jadwal) }}" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Bukti <span class="text-red-500">*</span></label>
                        <input type="file" name="foto_bukti" accept="image/*" required
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <p class="mt-1 text-xs text-gray-500">Unggah foto saat piket atau buku log. Maks 2 MB.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Hasil Piket <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi" rows="4" required
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="text-sm text-gray-500">
                        Waktu selesai akan tercatat otomatis saat laporan dikirim.
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <a href="{{ route('jadwal-jaga.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">Batal</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 text-sm">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
