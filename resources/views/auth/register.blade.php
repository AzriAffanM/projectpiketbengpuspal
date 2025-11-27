<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Piket Bengpuspal</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="login-container">
            <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" alt="Bengpuspal" class="login-logo">
            <h1 class="login-title">Sistem Piket Bengpuspal</h1>
            <p class="login-subtitle">Piket jaga malam terjadwal dan otomatis</p>
        </div>

        @if($errors->any())
            <div class="auth-session-status error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input" />
                @if($errors->has('name'))
                    <div class="error-message">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="form-input" />
                @if($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="form-input" />
                @if($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input" />
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Daftar sebagai</label>
                <select id="role" name="role" class="form-input">
                    <option value="petugas" {{ old('role', 'petugas') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if($errors->has('role'))
                    <div class="error-message">{{ $errors->first('role') }}</div>
                @endif
            </div>

            <div class="form-footer">
                <a href="{{ route('login') }}" class="register-link">Sudah punya akun? Masuk</a>
                <button type="submit" class="submit-button">Daftar</button>
            </div>
        </form>
    </div>
</body>
</html>
