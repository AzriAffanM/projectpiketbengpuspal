<x-guest-layout>
    <div class="flex flex-col items-center mb-5">
        <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" alt="Bengpuspal" class="w-20 h-20 object-contain">
        <h1 class="mt-3 text-2xl font-semibold text-emerald-900">Sistem Piket Bengpuspal</h1>
        <p class="mt-1 text-sm text-emerald-700">Piket jaga malam terjadwal dan otomatis</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Daftar sebagai</label>
            <select id="role" name="role" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                <option value="petugas" {{ old('role', 'petugas') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <a class="text-sm text-emerald-700 hover:text-emerald-900" href="{{ route('login') }}">Sudah punya akun? Masuk</a>
            <button class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-white font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">Daftar</button>
        </div>
    </form>
</x-guest-layout>
