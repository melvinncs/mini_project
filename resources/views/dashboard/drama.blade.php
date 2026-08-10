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
                        <td>
                            <a href="{{ route('dashboard.drama.show', $drama->slug) }}" class="btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <!-- Semua aksi tersedia untuk admin -->
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
        <div class="pagination-wrapper">
            {{ $dramas->links() }}
        </div>
        @else
        <p class="text-center">Belum ada drama. <a href="{{ route('dashboard.drama.create') }}">Tambah drama sekarang</a></p>
        @endif
    </div>
</div>
@endsection