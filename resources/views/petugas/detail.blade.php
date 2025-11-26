<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Petugas</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Nama</div>
                        <div class="text-base font-medium">{{ $petugas->nama }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">NRP</div>
                        <div class="text-base">{{ $petugas->nrp ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Urutan</div>
                        <div class="text-base font-medium">{{ $petugas->urutan }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Pangkat</div>
                        <div class="text-base">{{ $petugas->pangkat ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Jabatan</div>
                        <div class="text-base">{{ $petugas->jabatan ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Nomor Telepon</div>
                        <div class="text-base">{{ $petugas->nomor_telepon ?? '-' }}</div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('petugas.index') }}" class="px-4 py-2 border rounded">Kembali</a>
                    @if (auth()->user() && auth()->user()->role === 'admin')
                        <div class="space-x-2">
                            <a href="{{ route('petugas.edit', $petugas) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Edit</a>
                            <form action="{{ route('petugas.destroy', $petugas) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus petugas ini?')" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
