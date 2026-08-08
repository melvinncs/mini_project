@extends('layouts.app')

@section('title', 'Artikel Drama Korea - K-DramaHub')

@section('content')
    <section class="section" id="artikel" style="padding-top: 120px;">
        <div class="section-header">
            <span class="tag">📰 Informasi Terkini</span>
            <h2>Artikel <span class="highlight">Drama Korea</span></h2>
            <p>Berita, review, dan informasi menarik seputar dunia drama Korea</p>
        </div>

        <!-- Filter -->
        <div class="filter-wrapper">
            <input type="text" placeholder="Cari artikel..." class="filter-input">
            <select class="filter-select">
                <option value="">Semua Kategori</option>
                <option value="Review">Review</option>
                <option value="Rekomendasi">Rekomendasi</option>
                <option value="Pemeran">Pemeran</option>
                <option value="Perbandingan">Perbandingan</option>
                <option value="OST">OST</option>
                <option value="Preview">Preview</option>
                <option value="Berita">Berita</option>
            </select>
            <button class="filter-btn">🔍 Cari</button>
        </div>

        <!-- Grid Artikel -->
        <div class="article-grid">
            @php
                $allArtikels = [
                    [
                        'title' => 'Review Queen of Tears: Drama yang Bikin Baper Sepanjang Episode',
                        'excerpt' => 'Queen of Tears berhasil mencuri perhatian dengan alur cerita yang emosional dan akting memukau dari para pemainnya.',
                        'category' => 'Review',
                        'author' => 'Kim Min-ji',
                        'date' => '15 Mei 2024',
                        'thumb' => 'review-queen-of-tears.jpg',
                        'avatar' => 'avatar-1.jpg'
                    ],
                    [
                        'title' => 'Soundtrack Drama Korea Terbaik yang Bikin Galau',
                        'excerpt' => 'Soundtrack adalah salah satu elemen penting dalam drama Korea. Simak daftar OST terbaik yang bikin hati terenyuh.',
                        'category' => 'OST',
                        'author' => 'Choi Yeon-ju',
                        'date' => '5 Mei 2024',
                        'thumb' => 'best-ost.jpg',
                        'avatar' => 'avatar-5.jpg'
                    ],
                ];
            @endphp

            @foreach ($allArtikels as $artikel)
                <div class="article-card">
                    <img class="thumb" src="{{ asset('images/articles/' . $artikel['thumb']) }}" alt="{{ $artikel['title'] }}" loading="lazy">
                    <div class="info">
                        <span class="category">{{ $artikel['category'] }}</span>
                        <h3>{{ $artikel['title'] }}</h3>
                        <p>{{ $artikel['excerpt'] }}</p>
                        <div class="author">
                            <img src="{{ asset('images/authors/' . $artikel['avatar']) }}" alt="{{ $artikel['author'] }}" loading="lazy">
                            <div>
                                <div class="name">{{ $artikel['author'] }}</div>
                                <div class="date">{{ $artikel['date'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="section-footer">
            <a href="{{ route('artikel') }}" class="btn-primary">Baca Semua Artikel →</a>
        </div>
    </section>
@endsection