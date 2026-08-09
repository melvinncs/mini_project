@extends('dashboard.layout')

@section('title', 'Manajemen Artikel')

@section('content')
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
                        <th>No</th>
                        <th>Thumbnail</th>
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
                        <td>
                            @if($artikel->thumbnail)
                            <img src="{{ asset($artikel->thumbnail) }}" alt="Thumbnail" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            @else
                            <div style="width: 60px; height: 60px; background: #E4E4E7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #A1A1AA;">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                        </td>
                        <td>{{ $artikel->judul }}</td>
                        <td>{{ $artikel->pengguna->nama }}</td>
                        <td>{{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : '-' }}</td>
                        <td>
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