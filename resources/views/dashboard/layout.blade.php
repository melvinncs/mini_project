<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - K-DramaHub</title>
    @vite(['resources/css/dashboard.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">KD</div>
                <span>K-DramaHub</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('dashboard.artikel') }}" class="sidebar-link {{ request()->routeIs('dashboard.artikel*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Artikel</span>
                </a>
                @php
                    $pengguna = session('pengguna');
                    // Helper untuk mendapatkan nilai dari array atau object
                    $getPenggunaValue = function($key) use ($pengguna) {
                        if (!$pengguna) return null;
                        if (is_array($pengguna)) {
                            return $pengguna[$key] ?? null;
                        }
                        return $pengguna->$key ?? null;
                    };
                    $isAdmin = $getPenggunaValue('role') === 'admin';
                @endphp

                @if($isAdmin)
                <a href="{{ route('dashboard.drama') }}" class="sidebar-link {{ request()->routeIs('dashboard.drama*') ? 'active' : '' }}">
                    <i class="fas fa-film"></i>
                    <span>Drama</span>
                </a>
                @endif
                @php
                    $pengguna = session('pengguna');
                    // Helper untuk mendapatkan nilai dari array atau object
                    $getPenggunaValue = function($key) use ($pengguna) {
                        if (!$pengguna) return null;
                        if (is_array($pengguna)) {
                            return $pengguna[$key] ?? null;
                        }
                        return $pengguna->$key ?? null;
                    };
                    $isAdmin = $getPenggunaValue('role') === 'admin';
                @endphp
                @if($isAdmin)
                <a href="{{ route('dashboard.users.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i>
                    <span>Manajemen Akun</span>
                </a>
                <a href="{{ route('dashboard.landing-page') }}" class="sidebar-link {{ request()->routeIs('dashboard.landing-page') ? 'active' : '' }}">
                    <i class="fa fa-edit"></i> <span>Landing Page</span>
                </a>
                @endif
            </nav>
            
            <div class="sidebar-bottom">
                <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form> -->
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2>@yield('title')</h2>
                </div>
                <div class="topbar-right">
                    @php
                        $pengguna = session('pengguna');
                        $nama = $pengguna ? (is_array($pengguna) ? $pengguna['nama'] : $pengguna->nama) : 'User';
                        $role = $pengguna ? (is_array($pengguna) ? $pengguna['role'] : $pengguna->role) : 'user';
                    @endphp
                    <div class="user-info">
                        <span>{{ $nama }}</span>
                        <span class="badge-role">{{ $role }}</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });
    </script>
</body>
</html>