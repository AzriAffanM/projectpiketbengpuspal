<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Petugas</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-4 flex items-center justify-between">
                    <h1 class="text-2xl font-semibold">Petugas</h1>
                    <a href="{{ route('petugas.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Tambah Petugas</a>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Urutan</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">NRP</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Pangkat</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Jabatan</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nomor Telepon</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-600">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse ($petugas as $p)
                        <tr>
                            <td class="px-4 py-2">{{ $p->urutan }}</td>
                            <td class="px-4 py-2">{{ $p->nama }}</td>
                            <td class="px-4 py-2">{{ $p->nrp ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $p->pangkat ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $p->jabatan ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $p->nomor_telepon ?? '-' }}</td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="{{ route('petugas.show', $p) }}" class="text-blue-600 hover:underline">Detail</a>
                                <a href="{{ route('petugas.edit', $p) }}" class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route('petugas.destroy', $p) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline" onclick="return confirm('Hapus petugas ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada petugas.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="p-4">{{ $petugas->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
