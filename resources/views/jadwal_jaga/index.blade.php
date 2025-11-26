<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jadwal Piket</h2>
    </x-slot>

    <div class="py-6">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-semibold text-emerald-900">Jadwal Piket</h1>
      <a href="{{ route('jadwal-jaga.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-emerald-600 text-white shadow-sm hover:bg-emerald-700">Tambah Jadwal</a>
    </div>

    @if (session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    @if (session('info'))
      <div class="mb-4 p-3 bg-blue-100 text-blue-700 rounded">{{ session('info') }}</div>
    @endif

    <div class="bg-white/95 shadow-xl ring-1 ring-emerald-100 rounded-xl overflow-hidden">
      <table class="min-w-full divide-y divide-emerald-100">
        <thead class="bg-emerald-50/60">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Tanggal</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Petugas</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">NRP</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Jabatan</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Pangkat</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">NoTelp</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Shift</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-emerald-800">Status</th>
            <th class="px-4 py-2 text-right text-sm font-semibold text-emerald-800">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-emerald-100">
          @forelse ($jadwals as $j)
            <tr class="hover:bg-emerald-50/40">
              <td class="px-4 py-2">{{ \Illuminate\Support\Carbon::parse($j->tanggal_jaga)->format('d M Y') }}</td>
              <td class="px-4 py-2">{{ $j->petugas->nama ?? '-' }}</td>
              <td class="px-4 py-2">{{ $j->petugas->nrp ?? '-' }}</td>
              <td class="px-4 py-2">{{ $j->petugas->jabatan ?? '-' }}</td>
              <td class="px-4 py-2">{{ $j->petugas->pangkat ?? '-' }}</td>
              <td class="px-4 py-2">{{ $j->petugas->nomor_telepon ?? '-' }}</td>
              <td class="px-4 py-2 font-medium text-emerald-900">{{ substr($j->shift_mulai,0,5) }} - {{ substr($j->shift_selesai,0,5) }}</td>
              <td class="px-4 py-2">
                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full ring-1 ring-inset {{ $j->status === 'Sedang Bertugas' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-gray-50 text-gray-700 ring-gray-200' }}">
                  <span class="size-1.5 rounded-full {{ $j->status === 'Sedang Bertugas' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                  {{ $j->status }}
                </span>
              </td>
              <td class="px-4 py-2">
                <div class="flex items-center justify-end gap-2">
                  <a href="{{ route('jadwal-jaga.show', $j) }}" class="inline-flex items-center px-3 py-1.5 text-sm rounded-lg border border-emerald-200 text-emerald-800 hover:bg-emerald-50">Detail</a>
                  <a href="{{ route('jadwal-jaga.edit', $j) }}" class="inline-flex items-center px-3 py-1.5 text-sm rounded-lg border border-yellow-300 text-yellow-800 hover:bg-yellow-50">Edit</a>
                  <form action="{{ route('jadwal-jaga.destroy', $j) }}" method="POST" class="inline"
                        onsubmit="return confirm('Hapus jadwal ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="inline-flex items-center px-3 py-1.5 text-sm rounded-lg border border-red-300 text-red-700 hover:bg-red-50">Hapus</button>
                </form>
                @if ($j->status === 'Sedang Bertugas')
                <a href="{{ route('laporan-piket.create-from-jadwal', $j) }}" class="inline-flex items-center px-3 py-1.5 text-sm rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Selesai</a>
                <form action="{{ route('jadwal-jaga.gantikan', $j) }}" method="POST" class="inline" onsubmit="return confirm('Gantikan petugas ini dengan orang berikutnya dari kelompok selanjutnya?')">
                  @csrf
                  <button class="inline-flex items-center px-3 py-1.5 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Gantikan</button>
                </form>
                @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="px-4 py-6 text-center text-gray-500">Belum ada jadwal.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $jadwals->links() }}</div>
  </div>
    </div>
</x-app-layout>
