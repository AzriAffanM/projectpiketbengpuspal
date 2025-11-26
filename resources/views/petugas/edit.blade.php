<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-emerald-900 leading-tight">Ubah Petugas</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white/95 shadow-xl ring-1 ring-emerald-100 sm:rounded-xl">
                <div class="p-6 sm:p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-emerald-900">Perbarui Data Petugas</h3>
                        <p class="text-sm text-emerald-700/80 mt-1">Pastikan data sesuai sebelum menyimpan perubahan.</p>
                    </div>

                    <form action="{{ route('petugas.update', $petugas) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-emerald-800">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama', $petugas->nama) }}" class="mt-1 w-full rounded-lg border border-emerald-300 bg-white px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                            @error('nama')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-emerald-800">NRP</label>
                            <input type="text" name="nrp" value="{{ old('nrp', $petugas->nrp) }}" class="mt-1 w-full rounded-lg border border-emerald-300 bg-white px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                            @error('nrp')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-emerald-800">Pangkat</label>
                                <input type="text" name="pangkat" value="{{ old('pangkat', $petugas->pangkat) }}" class="mt-1 w-full rounded-lg border border-emerald-300 px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                                @error('pangkat')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-emerald-800">Jabatan</label>
                                <input type="text" name="jabatan" value="{{ old('jabatan', $petugas->jabatan) }}" class="mt-1 w-full rounded-lg border border-emerald-300 px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                                @error('jabatan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-emerald-800">Nomor Telepon</label>
                                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $petugas->nomor_telepon) }}" class="mt-1 w-full rounded-lg border border-emerald-300 px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                                @error('nomor_telepon')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-emerald-800">Urutan</label>
                            <input type="number" name="urutan" value="{{ old('urutan', $petugas->urutan) }}" min="1" class="mt-1 w-full rounded-lg border border-emerald-300 px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                            @error('urutan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('petugas.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-emerald-300 text-emerald-800 hover:bg-emerald-50">Batal</a>
                            <button class="inline-flex items-center px-4 py-2 rounded-lg bg-emerald-700 text-white hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
