@extends('dashboard.layout')

@section('title', $artikel->judul)

@section('content')
<div class="article-detail">
    <div class="article-header">
        <h1>{{ $artikel->judul }}</h1>
        <div class="article-meta">
            <span><i class="fas fa-user"></i> {{ $artikel->pengguna->nama }}</span>
            <span><i class="fas fa-calendar"></i> {{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y, H:i') : '-' }}</span>
            <span><i class="fas fa-tag"></i> {{ $artikel->pengguna->role }}</span>
        </div>
    </div>

    @if($artikel->thumbnail)
    <div class="article-thumbnail">
        <img src="{{ asset($artikel->thumbnail) }}" alt="{{ $artikel->judul }}" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px;">
    </div>
    @endif

    <div class="article-content">
        {!! nl2br(e($artikel->isi)) !!}
    </div>

    <div class="article-actions">
        @if(isset($pengguna) && ($pengguna->role === 'admin' || $pengguna->id === $artikel->id_pengguna))
        <a href="{{ route('dashboard.artikel.edit', $artikel->id) }}" class="btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('dashboard.artikel.delete', $artikel->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger" onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
        @endif
        <a href="{{ route('dashboard.artikel') }}" class="btn-secondary">Kembali</a>
    </div>
</div>
@endsection