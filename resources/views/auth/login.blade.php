<x-guest-layout>
    <div class="flex flex-col items-center mb-5">
        <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" alt="Bengpuspal" class="w-20 h-20 object-contain">
        <h1 class="mt-3 text-2xl font-semibold text-emerald-900">Sistem Piket Bengpuspal</h1>
        <p class="mt-1 text-sm text-emerald-700">Piket jaga malam terjadwal dan otomatis</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="mt-1 block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-emerald-700 hover:text-emerald-800" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('register') }}" class="text-sm text-emerald-700 hover:text-emerald-900">Belum punya akun? Daftar</a>
            <button class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-white font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">Masuk</button>
        </div>
    </form>
</x-guest-layout>
