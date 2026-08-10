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
    </div>
    <div class="card-body">
        @if($artikels->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 80px;">Thumbnail</th>
                        <th style="width: 35%;">Judul</th>
                        <th style="width: 20%;">Penulis</th>
                        <th style="width: 20%;">Diterbitkan</th>
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

@if(isset($pengguna) && $pengguna->role === 'admin')
<div class="card">
    <div class="card-header">
        <h3>Daftar Drama</h3>
    </div>
    <div class="card-body">
        @if($dramas->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Genre</th>
                        <th>Tahun</th>
                        <th>Episode</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Penulis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dramas as $index => $drama)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($drama->thumbnail)
                            <img src="{{ asset($drama->thumbnail) }}" alt="Thumbnail" style="width: 60px; height: 80px; object-fit: cover; border-radius: 8px;">
                            @else
                            <div style="width: 60px; height: 80px; background: #E4E4E7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #A1A1AA;">
                                <i class="fas fa-film"></i>
                            </div>
                            @endif
                        </td>
                        <td>{{ $drama->judul }}</td>
                        <td>{{ $drama->genre ?? '-' }}</td>
                        <td>{{ $drama->tahun ?? '-' }}</td>
                        <td>{{ $drama->episode ?? '-' }}</td>
                        <td>{{ $drama->rating ?? '-' }}</td>
                        <td>
                            <span class="badge-role {{ $drama->status_badge }}">
                                {{ $drama->status }}
                            </span>
                        </td>
                        <td>{{ $drama->pengguna->nama }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $dramas->links() }}
        </div>
        @else
        <p class="text-center">Belum ada drama.</p>
        @endif
    </div>
</div>
@endif
@endsection