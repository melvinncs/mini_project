@extends('dashboard.layout')

@section('title', 'Manajemen Drama')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Drama</h3>
        <a href="{{ route('dashboard.drama.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Drama
        </a>
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
                        <th>Aksi</th>
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
                        <td>
                            <a href="{{ route('dashboard.drama.show', $drama->slug) }}" class="btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('dashboard.drama.edit', $drama->id) }}" class="btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('dashboard.drama.delete', $drama->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus drama ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
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
                    <a href="{{ $dramas->url(1) }}" style="padding: 8px 12px; background: #F3F4F6; color: #374151; border-radius: 6px; text-decoration: none; font-size: 14px; transition: all 0.2px;">1</a>
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
        <p class="text-center">Belum ada drama. <a href="{{ route('dashboard.drama.create') }}">Tambah drama sekarang</a></p>
        @endif
    </div>
</div>

<style>
.pagination-links a:hover {
    background: #E5E7EB !important;
}
</style>
@endsection