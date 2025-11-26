<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Jadwal Piket</h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-3xl mx-auto px-6">
        <div class="bg-white/95 shadow-xl ring-1 ring-emerald-100 sm:rounded-xl">
          <div class="p-6 sm:p-8">
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-emerald-900">Form Jadwal Piket</h3>
              <p class="text-sm text-emerald-700/80 mt-1">Isi data berikut untuk menambahkan jadwal piket.</p>
            </div>

            <form action="{{ route('jadwal-jaga.store') }}" method="POST" class="space-y-6">
              @csrf

              <div>
                <label class="block text-sm font-medium text-emerald-800">Petugas</label>
                <select name="petugas_id" class="mt-1 w-full rounded-lg border border-emerald-300 bg-white px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40">
                  @foreach ($petugas as $p)
                    <option value="{{ $p->id }}" @selected(old('petugas_id')==$p->id)>{{ $p->nama }} (Urutan {{ $p->urutan }})</option>
                  @endforeach
                </select>
                @error('petugas_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
              </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label class="block text-sm font-medium text-emerald-800">Tanggal Jaga</label>
                  <input type="date" name="tanggal_jaga" value="{{ old('tanggal_jaga', now()->toDateString()) }}" class="mt-1 w-full rounded-lg border border-emerald-300 bg-white px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                  @error('tanggal_jaga')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                  <label class="block text-sm font-medium text-emerald-800">Shift Mulai</label>
                  <input type="time" name="shift_mulai" value="{{ old('shift_mulai', '19:00') }}" class="mt-1 w-full rounded-lg border border-emerald-300 bg-white px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                  @error('shift_mulai')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                  <label class="block text-sm font-medium text-emerald-800">Shift Selesai</label>
                  <input type="time" name="shift_selesai" value="{{ old('shift_selesai', '07:00') }}" class="mt-1 w-full rounded-lg border border-emerald-300 bg-white px-3 py-2 shadow-sm focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/40" />
                  @error('shift_selesai')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
              </div>

              <div class="flex items-center justify-end gap-3">
                <a href="{{ route('jadwal-jaga.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-emerald-300 text-emerald-800 hover:bg-emerald-50">Batal</a>
                <button class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</x-app-layout>
