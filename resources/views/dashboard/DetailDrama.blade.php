@extends('layouts.app')

@section('content')
<div class="article-detail-page">
    <div class="container">
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
                    <span><i class="fas fa-tag"></i> {{ $drama->status ?? 'Ongoing' }}</span>
                    <span><i class="fas fa-user"></i> {{ $drama->pengguna->nama ?? 'Admin' }}</span>
                </div>
            </div>

            @if($drama->thumbnail)
            <div class="article-thumbnail">
                <img src="{{ asset($drama->thumbnail) }}" alt="{{ $drama->judul }}">
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

            <div class="article-navigation">
                <a href="{{ route('drama') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Drama
                </a>
                <a href="{{ route('home') }}#drama" class="btn-primary">
                    <i class="fas fa-home"></i> Kembali ke Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection