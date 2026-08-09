@extends('layouts.app')

@section('content')
<div class="article-detail-page">
    <div class="container">

        <!-- Breadcrumb / Back -->
        <div class="article-navigation-top">
            <a href="{{ route('home') }}#artikel" class="btn-secondary">
                ← Kembali ke Artikel
            </a>
        </div>

        <div class="article-card">
            <div class="article-header">
                <span class="category">{{ $artikel->kategori ?? 'Artikel' }}</span>
                <h1>{{ $artikel->judul }}</h1>
                <div class="article-meta">
                    <span>
                        <i class="fas fa-user"></i>
                        {{ $artikel->pengguna->nama ?? 'Admin' }}
                    </span>
                    <span>
                        <i class="fas fa-calendar"></i>
                        {{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y, H:i') : 'Belum dipublikasi' }}
                    </span>
                </div>
            </div>

            @if($artikel->thumbnail)
            <div class="article-thumbnail">
                <img src="{{ asset($artikel->thumbnail) }}" alt="{{ $artikel->judul }}" loading="lazy">
            </div>
            @endif

            <div class="article-content">
                {!! nl2br(e($artikel->isi)) !!}
            </div>

            <div class="article-navigation">
                <a href="{{ route('home') }}#artikel" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Artikel
                </a>
                <a href="{{ route('home') }}#artikel" class="btn-primary">
                    Lihat Artikel Lainnya →
                </a>
            </div>
        </div>

        <!-- Artikel Terkait -->
        @if(isset($artikels) && $artikels->where('slug', '!=', $artikel->slug)->count() > 0)
        <div class="related-articles">
            <div class="section-header">
                <span class="tag">📰 Baca Juga</span>
                <h2>Artikel <span class="highlight">Terkait</span></h2>
            </div>

            <div class="article-grid">
                @foreach ($artikels->where('slug', '!=', $artikel->slug)->take(3) as $related)
                    <div class="article-card">
                        <img class="thumb"
                            src="{{ $related->thumbnail ? asset($related->thumbnail) : asset('images/default-article.jpg') }}"
                            alt="{{ $related->judul }}"
                            loading="lazy">
                        <div class="info">
                            <span class="category">{{ $related->kategori ?? 'Artikel' }}</span>
                            <h3>{{ $related->judul }}</h3>
                            <p>{{ Str::limit(strip_tags($related->isi), 120) }}</p>
                            <div class="author">
                                <div>
                                    <div class="name">{{ $related->pengguna->nama ?? 'Admin' }}</div>
                                    <div class="date">{{ $related->diterbitkan_pada ? $related->diterbitkan_pada->format('d M Y') : 'Belum dipublikasi' }}</div>
                                </div>
                            </div>
                            <a href="{{ route('artikel.detail', $related->slug) }}" class="read-more">Baca Selengkapnya →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection