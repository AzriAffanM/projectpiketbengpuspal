<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ubah Jadwal Piket</h2>
    </x-slot>

    <div class="py-6">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
          <form action="{{ route('jadwal-jaga.update', $jadwal) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
              <label class="block text-sm text-gray-700 mb-1">Petugas</label>
              <select name="petugas_id" class="w-full border rounded px-3 py-2">
                @foreach ($petugas as $p)
                  <option value="{{ $p->id }}" @selected(old('petugas_id', $jadwal->petugas_id)==$p->id)>{{ $p->nama }} (Urutan {{ $p->urutan }})</option>
                @endforeach
              </select>
              @error('petugas_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div>
                <label class="block text-sm text-gray-700 mb-1">Tanggal Jaga</label>
                <input type="date" name="tanggal_jaga" value="{{ old('tanggal_jaga', $jadwal->tanggal_jaga) }}" class="w-full border rounded px-3 py-2" />
                @error('tanggal_jaga')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="block text-sm text-gray-700 mb-1">Shift Mulai</label>
                <input type="time" name="shift_mulai" value="{{ old('shift_mulai', substr($jadwal->shift_mulai,0,5)) }}" class="w-full border rounded px-3 py-2" />
                @error('shift_mulai')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
              </div>
              <div>
                <label class="block text-sm text-gray-700 mb-1">Shift Selesai</label>
                <input type="time" name="shift_selesai" value="{{ old('shift_selesai', substr($jadwal->shift_selesai,0,5)) }}" class="w-full border rounded px-3 py-2" />
                @error('shift_selesai')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
              </div>
            </div>

            <div>
              <label class="block text-sm text-gray-700 mb-1">Status</label>
              <select name="status" class="w-full border rounded px-3 py-2">
                <option value="Sedang Bertugas" @selected(old('status', $jadwal->status)=='Sedang Bertugas')>Sedang Bertugas</option>
                <option value="Selesai" @selected(old('status', $jadwal->status)=='Selesai')>Selesai</option>
              </select>
              @error('status')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('jadwal-jaga.index') }}" class="px-4 py-2 border rounded">Batal</a>
              <button class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</x-app-layout>
