@extends('layouts.app')

@section('content')
<div class="article-detail-page">
    <div class="container">
        <div class="article-card">
            <div class="article-header">
                <span class="article-category">{{ $artikel->kategori ?? 'Artikel' }}</span>
                <h1>{{ $artikel->judul }}</h1>
                <div class="article-meta">
                    <span><i class="fas fa-user"></i> {{ $artikel->pengguna->nama ?? 'Admin' }}</span>
                    <span><i class="fas fa-calendar"></i> {{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y, H:i') : 'Belum dipublikasi' }}</span>
                </div>
            </div>

            @if($artikel->thumbnail)
            <div class="article-thumbnail">
                <img src="{{ asset($artikel->thumbnail) }}" alt="{{ $artikel->judul }}">
            </div>
            @endif

            <div class="article-content">
                {!! nl2br(e($artikel->isi)) !!}
            </div>

            <div class="article-navigation">
                <a href="{{ route('home') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
