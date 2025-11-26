<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Jadwal Piket</h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <div class="text-sm text-gray-500">Tanggal</div>
              <div class="text-base">{{ \Illuminate\Support\Carbon::parse($jadwal->tanggal_jaga)->format('d M Y') }}</div>
            </div>
            <div>
              <div class="text-sm text-gray-500">Petugas</div>
              <div class="text-base">{{ $jadwal->petugas->nama ?? '-' }}</div>
            </div>
            <div>
              <div class="text-sm text-gray-500">Shift</div>
              <div class="text-base">{{ substr($jadwal->shift_mulai,0,5) }} - {{ substr($jadwal->shift_selesai,0,5) }}</div>
            </div>
            <div>
              <div class="text-sm text-gray-500">Status</div>
              <div class="text-base">{{ $jadwal->status }}</div>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <a href="{{ route('jadwal-jaga.index') }}" class="px-4 py-2 border rounded">Kembali</a>
            @if ($jadwal->status === 'Sedang Bertugas')
            <div class="flex items-center gap-2">
              <form action="{{ route('jadwal-jaga.selesai', $jadwal) }}" method="POST">
                @csrf
                <button class="px-4 py-2 bg-emerald-600 text-white rounded">Selesai</button>
              </form>
              <form action="{{ route('jadwal-jaga.gantikan', $jadwal) }}" method="POST" onsubmit="return confirm('Gantikan petugas ini dengan orang berikutnya dari kelompok selanjutnya?')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Gantikan</button>
              </form>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
</x-app-layout>
