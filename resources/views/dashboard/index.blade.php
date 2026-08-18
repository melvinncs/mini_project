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
                        <td>{{ $artikels->firstItem() + $index }}</td>
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
        
        <!-- Pagination untuk Artikel -->
        <div class="pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; flex-wrap: wrap; gap: 10px;">
            <div class="pagination-info">
                <span style="color: #6B7280; font-size: 14px;">
                    Showing {{ $artikels->firstItem() }} to {{ $artikels->lastItem() }} of {{ $artikels->total() }} results
                </span>
            </div>
            <div class="pagination-links" style="display: flex; align-items: center; gap: 5px;">
                @if ($artikels->onFirstPage())
                    <span style="padding: 8px 12px; background: #E5E7EB; color: #9CA3AF; border-radius: 6px; cursor: not-allowed; font-size: 14px;">« Previous</span>
                @else
                    <a href="{{ $artikels->previousPageUrl() }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">« Previous</a>
                @endif
                
                @php
                    $currentPage = $artikels->currentPage();
                    $lastPage = $artikels->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp
                
                @if ($start > 1)
                    <a href="{{ $artikels->url(1) }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">1</a>
                    @if ($start > 2)
                        <span style="padding: 8px 4px; color: #9CA3AF;">...</span>
                    @endif
                @endif
                
                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $currentPage)
                        <span style="padding: 8px 12px; background: #4F46E5; color: white; border-radius: 6px; font-size: 14px; font-weight: 600;">{{ $i }}</span>
                    @else
                        <a href="{{ $artikels->url($i) }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">{{ $i }}</a>
                    @endif
                @endfor
                
                @if ($end < $lastPage)
                    @if ($end < $lastPage - 1)
                        <span style="padding: 8px 4px; color: #9CA3AF;">...</span>
                    @endif
                    <a href="{{ $artikels->url($lastPage) }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">{{ $lastPage }}</a>
                @endif
                
                @if ($artikels->hasMorePages())
                    <a href="{{ $artikels->nextPageUrl() }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">Next »</a>
                @else
                    <span style="padding: 8px 12px; background: #E5E7EB; color: #9CA3AF; border-radius: 6px; cursor: not-allowed; font-size: 14px;">Next »</span>
                @endif
            </div>
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
                        <td>{{ $dramas->firstItem() + $index }}</td>
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
        
        <!-- Pagination untuk Drama -->
        <div class="pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; flex-wrap: wrap; gap: 10px;">
            <div class="pagination-info">
                <span style="color: #6B7280; font-size: 14px;">
                    Showing {{ $dramas->firstItem() }} to {{ $dramas->lastItem() }} of {{ $dramas->total() }} results
                </span>
            </div>
            <div class="pagination-links" style="display: flex; align-items: center; gap: 5px;">
                @if ($dramas->onFirstPage())
                    <span style="padding: 8px 12px; background: #E5E7EB; color: #9CA3AF; border-radius: 6px; cursor: not-allowed; font-size: 14px;">« Previous</span>
                @else
                    <a href="{{ $dramas->previousPageUrl() }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">« Previous</a>
                @endif
                
                @php
                    $currentPage = $dramas->currentPage();
                    $lastPage = $dramas->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp
                
                @if ($start > 1)
                    <a href="{{ $dramas->url(1) }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">1</a>
                    @if ($start > 2)
                        <span style="padding: 8px 4px; color: #9CA3AF;">...</span>
                    @endif
                @endif
                
                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $currentPage)
                        <span style="padding: 8px 12px; background: #4F46E5; color: white; border-radius: 6px; font-size: 14px; font-weight: 600;">{{ $i }}</span>
                    @else
                        <a href="{{ $dramas->url($i) }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">{{ $i }}</a>
                    @endif
                @endfor
                
                @if ($end < $lastPage)
                    @if ($end < $lastPage - 1)
                        <span style="padding: 8px 4px; color: #9CA3AF;">...</span>
                    @endif
                    <a href="{{ $dramas->url($lastPage) }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">{{ $lastPage }}</a>
                @endif
                
                @if ($dramas->hasMorePages())
                    <a href="{{ $dramas->nextPageUrl() }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2s;">Next »</a>
                @else
                    <span style="padding: 8px 12px; background: #E5E7EB; color: #9CA3AF; border-radius: 6px; cursor: not-allowed; font-size: 14px;">Next »</span>
                @endif
            </div>
        </div>
        @else
        <p class="text-center">Belum ada drama.</p>
        @endif
    </div>
</div>
@endif

<style>
.pagination-links a:hover {
    background: #E5E7EB !important;
}
</style>
@endsection