<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Piket Bengpuspal</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="login-container">
            <img src="{{ asset('images/Logo_Pusat_Peralatan_Angkatan_Darat.png') }}" alt="Bengpuspal" class="login-logo">
            <h1 class="login-title">Sistem Piket Bengpuspal</h1>
            <p class="login-subtitle">Piket jaga malam terjadwal dan otomatis</p>
        </div>

        @if(session('status'))
            <div class="auth-session-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input" />
                @if($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-input" />
                @if($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-options">
                <label for="remember_me" class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>

            <div class="form-footer">
                <a href="{{ route('register') }}" class="register-link">Belum punya akun? Daftar</a>
                <button type="submit" class="submit-button">Masuk</button>
            </div>
        </form>
    </div>
</body>
</html>
