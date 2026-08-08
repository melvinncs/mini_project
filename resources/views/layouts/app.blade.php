<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'K-DramaHub - Portal Informasi Drama Korea')</title>
    <meta name="description" content="Portal informasi drama Korea terlengkap. Temukan drama terbaru, populer, detail pemeran, genre, rating, dan episode.">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/style.css'])

    <!-- Font Awesome untuk ikon sosial -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="brand-icon">KD</div>
            <span>K-DramaHub</span>
        </a>

        <ul class="navbar-links" id="navLinks">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('drama') }}" class="{{ request()->routeIs('drama') ? 'active' : '' }}">Drama</a></li>
            <li><a href="{{ route('artikel') }}" class="{{ request()->routeIs('artikel') ? 'active' : '' }}">Artikel</a></li>
        </ul>

        <div class="navbar-actions">
            <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            <a href="{{ route('register') }}" class="btn-register">Daftar</a>

            <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <div class="navbar-actions-mobile">
            <a href="#" class="btn-login-mobile">Masuk</a>
            <a href="#" class="btn-register-mobile">Daftar</a>
        </div>
    </nav>

    <!-- ===== CONTENT ===== -->
    <main>
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <div style="
                        width: 40px;
                        height: 40px;
                        background: var(--gradient-main);
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 18px;
                        font-weight: 900;
                        color: white;
                        box-shadow: var(--shadow-glow);
                    ">KD</div>
                    <span style="font-size: 22px; font-weight: 900; background: var(--gradient-main); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">K-DramaHub</span>
                </div>
                <p>Portal informasi drama Korea terlengkap. Temukan drama terbaru, populer, detail pemeran, genre, rating, dan episode.</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-discord"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Menu</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('drama') }}">Drama</a></li>
                    <li><a href="{{ route('artikel') }}">Artikel</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Ikuti Kami</h4>
                <ul>
                    <li><a href="#"><i class="fab fa-instagram" style="margin-right: 8px;"></i> Instagram</a></li>
                    <li><a href="#"><i class="fab fa-twitter" style="margin-right: 8px;"></i> Twitter</a></li>
                    <li><a href="#"><i class="fab fa-youtube" style="margin-right: 8px;"></i> YouTube</a></li>
                    <li><a href="#"><i class="fab fa-tiktok" style="margin-right: 8px;"></i> TikTok</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} K-DramaHub. All rights reserved.</p>
            <p>Dibuat dengan ❤️ untuk pecinta drama Korea</p>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            navLinks.classList.toggle('open');
        });

        // Close mobile menu on link click
        document.querySelectorAll('.navbar-links a').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                navLinks.classList.remove('open');
            });
        });

        // Highlight active nav link based on current page
        document.querySelectorAll('.navbar-links a').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    </script>
</body>
</html>