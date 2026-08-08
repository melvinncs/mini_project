<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - K-DramaHub</title>
    @vite(['resources/css/style.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="auth-page">
        <div class="auth-container">

            <!-- Header -->
            <div class="auth-header">
                <a href="{{ route('home') }}" class="auth-logo">
                    <div class="brand-icon">KD</div>
                    <span>K-DramaHub</span>
                </a>
                <h1>Selamat Datang Kembali</h1>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Alert -->
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Login -->
            <form class="auth-form" action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                    </div>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- <div class="form-options">
                    <label class="remember">
                        <input type="checkbox" name="remember"> Ingat Saya
                    </label>
                    <a href="#" class="forgot-link">Lupa Password?</a>
                </div> -->

                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <!-- Divider -->
            <div class="auth-divider">atau</div>

            <!-- Footer -->
            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>

        </div>
    </div>

</body>
</html>