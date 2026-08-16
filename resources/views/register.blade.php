<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - K-DramaHub</title>
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
                <h1>Buat Akun Baru</h1>
                <p>Daftar untuk mulai menjelajahi drama Korea</p>
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

            <!-- Form Register -->
            <form class="auth-form" action="{{ route('register.proses') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama') }}" required>
                    </div>
                    @error('nama')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

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
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                    </div>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-check-circle input-icon"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password Anda" required>
                    </div>
                </div>

                <!-- <div class="terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a></label>
                </div> -->

                <button type="submit" class="btn-submit">Daftar Sekarang</button>
            </form>

            <!-- Divider -->
            <div class="auth-divider">atau</div>

            <!-- Footer -->
            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a>
            </div>

        </div>
    </div>

</body>
</html>