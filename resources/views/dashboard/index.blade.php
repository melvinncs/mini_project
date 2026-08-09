@extends('dashboard.layout')

@section('title', 'Dashboard')

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
    <div class="stat-card">
        <div class="stat-icon" style="background: #6C63FF;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalUsers }}</h3>
            <p>Total Pengguna</p>
        </div>
    </div>
    @if(isset($pengguna) && $pengguna->role === 'admin')
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
        <h3>Artikel Terbaru</h3>
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
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Diterbitkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($artikels as $index => $artikel)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $artikel->judul }}</td>
                        <td>{{ $artikel->pengguna->nama }}</td>
                        <td>{{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('dashboard.artikel.show', $artikel->slug) }}" class="btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($pengguna->role === 'admin' || $pengguna->id === $artikel->id_pengguna)
                            <a href="{{ route('dashboard.artikel.edit', $artikel->id) }}" class="btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('dashboard.artikel.delete', $artikel->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
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
        <p class="text-center">Belum ada artikel.</p>
        @endif
    </div>
</div>
@endsection