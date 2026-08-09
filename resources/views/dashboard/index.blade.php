@extends('dashboard.layout')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #FF2D55;">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalArtikel }}</h3>
            <p>Total Artikel</p>
        </div>
    </div>

    @if(isset($pengguna) && $pengguna->role === 'admin')
    <div class="stat-card">
        <div class="stat-icon" style="background: #6C63FF;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalUsers }}</h3>
            <p>Total Pengguna</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #FFB703;">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $admins->count() }}</h3>
            <p>Total Admin</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #34A853;">
            <i class="fas fa-user"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $users->count() }}</h3>
            <p>Total User</p>
        </div>
    </div>
    @endif
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Artikel</h3>
        <a href="{{ route('dashboard.artikel.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Buat Artikel
        </a>
    </div>
    <div class="card-body">
        @if($artikels->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 80px;">Thumbnail</th>
                        <th style="width: 30%;">Judul</th>
                        <th style="width: 15%;">Penulis</th>
                        <th style="width: 15%;">Diterbitkan</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($artikels as $index => $artikel)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($artikel->thumbnail)
                            <img src="{{ asset($artikel->thumbnail) }}" alt="Thumbnail" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            @else
                            <div style="width: 60px; height: 60px; background: #E4E4E7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #A1A1AA;">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                        </td>
                        <td style="word-wrap: break-word; word-break: break-word;">{{ $artikel->judul }}</td>
                        <td>{{ $artikel->pengguna->nama }}</td>
                        <td>{{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                <a href="{{ route('dashboard.artikel.show', $artikel->slug) }}" class="btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @php
                                $pengguna = session('pengguna');
                                @endphp

                                @if($pengguna && (
                                    ($pengguna['role'] ?? null) === 'admin' ||
                                    ($pengguna['id'] ?? null) === $artikel->id_pengguna
                                ))
                                    <a href="{{ route('dashboard.artikel.edit', $artikel->id) }}" class="btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('dashboard.artikel.delete', $artikel->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $artikels->links() }}
        </div>
        @else
        <p class="text-center">Belum ada artikel. <a href="{{ route('dashboard.artikel.create') }}">Buat artikel sekarang</a></p>
        @endif
    </div>
</div>
@endsection