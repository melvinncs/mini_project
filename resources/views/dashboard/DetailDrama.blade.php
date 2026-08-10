@extends('dashboard.layout')

@section('title', $drama->judul)

@section('content')
<div class="article-detail-page">
    <div class="container" style="max-width: 760px; margin: 0 auto; padding: 0 24px;">
        <a href="{{ route('dashboard.drama') }}" class="btn-secondary" style="margin-bottom: 20px; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        
        <div class="article-card">
            <div class="article-header">
                <span class="article-category">{{ $drama->genre ?? 'Drama' }}</span>
                <h1>{{ $drama->judul }}</h1>
                
                <div class="article-meta">
                    <span><i class="fas fa-calendar"></i> {{ $drama->tahun ?? 'Tahun tidak tersedia' }}</span>
                    <span><i class="fas fa-film"></i> {{ $drama->episode ?? '?' }} Episode</span>
                    @if($drama->rating)
                    <span><i class="fas fa-star" style="color: #F59E0B;"></i> {{ $drama->rating }}</span>
                    @endif
                    <span><i class="fas fa-tag"></i> {{ $drama->status }}</span>
                    <span><i class="fas fa-user"></i> {{ $drama->pengguna->nama }}</span>
                </div>
            </div>

            @if($drama->thumbnail)
            <div class="article-thumbnail">
                <img src="{{ asset($drama->thumbnail) }}" alt="{{ $drama->judul }}" style="width: 100%; max-height: 420px; object-fit: cover; display: block;">
            </div>
            @endif

            <div class="article-content">
                @if($drama->pemeran_utama)
                <div style="background: #F8F8FA; padding: 16px 20px; border-radius: 10px; margin-bottom: 24px;">
                    <strong style="display: block; margin-bottom: 4px;">👤 Pemeran Utama</strong>
                    <p style="margin: 0; color: #52525B;">{{ $drama->pemeran_utama }}</p>
                </div>
                @endif

                <div>
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px;">Sinopsis</h3>
                    <p style="line-height: 1.9; color: var(--text-light);">
                        {{ $drama->sinopsis ?? 'Sinopsis belum tersedia.' }}
                    </p>
                </div>
            </div>

            <!-- Tombol aksi untuk admin (tanpa pengecekan) -->
            <div class="article-navigation">
                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('dashboard.drama.edit', $drama->id) }}" class="btn-primary" style="flex: 1; justify-content: center;">
                        <i class="fas fa-edit"></i> Edit Drama
                    </a>
                    <form action="{{ route('dashboard.drama.delete', $drama->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-secondary" style="width: 100%; justify-content: center; color: #DC2626; border-color: #DC2626;"
                                onclick="return confirm('Yakin ingin menghapus drama ini?')">
                            <i class="fas fa-trash"></i> Hapus Drama
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection