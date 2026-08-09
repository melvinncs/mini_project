@extends('layouts.app')

@section('content')
    <!-- HOME -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badges">
                    <span class="hero-badge">
                        <span class="dot"></span> #1 Drama Korea
                    </span>
                    <span class="hero-badge">⭐ 4.8/5 Rating</span>
                    <span class="hero-badge">🔥 500+ Drama</span>
                </div>

                <h1>
                    Portal <span class="highlight">Drama Korea</span><br>
                    Terlengkap & Terupdate
                </h1>

                <p>
                    Temukan informasi drama terbaru, drama populer, detail pemeran,
                    genre, rating, dan episode. Semua dalam satu platform.
                </p>

                <div class="hero-cta">
                    <a href="#drama" class="btn-primary">
                        Jelajahi Drama →
                    </a>
                    <a href="#artikel" class="btn-secondary">
                        Baca Artikel
                    </a>
                </div>
            </div>

            <div class="hero-image">
                <div class="hero-image-wrapper">
                    <div class="circle-bg"></div>
                    <img src="{{ asset('image/home.png') }}" alt="K-DramaHub Hero" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- DRAMA -->
    <section class="section" id="drama">
        <div class="section-header">
            <span class="tag">🔥 Trending Now</span>
            <h2>Drama <span class="highlight">Populer</span></h2>
            <p>Drama Korea terbaik pilihan pengguna dengan rating tertinggi</p>
        </div>

        <!-- Filter Drama -->
        <div class="filter-wrapper">
            <input type="text" placeholder="Cari drama..." class="filter-input">
            <select class="filter-select">
                <option value="">Semua Genre</option>
                <option value="Romance">Romance</option>
                <option value="Drama">Drama</option>
                <option value="Thriller">Thriller</option>
                <option value="Comedy">Comedy</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Action">Action</option>
            </select>
            <select class="filter-select">
                <option value="">Semua Tahun</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2020">2020</option>
            </select>
            <button class="filter-btn">🔍 Cari</button>
        </div>

        <div class="drama-grid">
            @php
                $dramas = [
                    [
                        'title' => 'Queen of Tears',
                        'poster' => 'queen-of-tears.jpg',
                        'year' => '2024',
                        'rating' => '9.2',
                        'episodes' => '16',
                        'genres' => ['Romance', 'Drama', 'Melodrama'],
                        'badge' => '🔥 Hot',
                        'badge_class' => 'badge-hot',
                        'sinopsis' => 'Kisah cinta yang mengharukan antara sepasang suami istri yang harus menghadapi berbagai cobaan dalam pernikahan mereka.',
                        'cast' => ['Kim Soo-hyun', 'Kim Ji-won', 'Park Sung-hoon']
                    ],
                    [
                        'title' => 'Lovely Runner',
                        'poster' => 'lovely-runner.jpg',
                        'year' => '2024',
                        'rating' => '8.9',
                        'episodes' => '16',
                        'genres' => ['Romance', 'Fantasy', 'Comedy'],
                        'badge' => '✨ New',
                        'badge_class' => 'badge-new',
                        'sinopsis' => 'Seorang penggemar berat yang melakukan perjalanan waktu untuk menyelamatkan idolanya dari masa lalu.',
                        'cast' => ['Byeon Woo-seok', 'Kim Hye-yoon', 'Song Geon-hee']
                    ],
                    [
                        'title' => 'The Glory',
                        'poster' => 'the-glory.jpg',
                        'year' => '2023',
                        'rating' => '8.7',
                        'episodes' => '16',
                        'genres' => ['Thriller', 'Drama', 'Revenge'],
                        'badge' => '🔥 Hot',
                        'badge_class' => 'badge-hot',
                        'sinopsis' => 'Kisah balas dendam seorang wanita yang merencanakan pembalasan terhadap para pelaku bullying di masa sekolahnya.',
                        'cast' => ['Song Hye-kyo', 'Lee Do-hyun', 'Lim Ji-yeon']
                    ],
                    [
                        'title' => 'Reply 1988',
                        'poster' => 'reply-1988.jpg',
                        'year' => '2015',
                        'rating' => '9.1',
                        'episodes' => '20',
                        'genres' => ['Keluarga', 'Drama', 'Komedi'],
                        'badge' => '💛 Classic',
                        'badge_class' => 'badge-populer',
                        'sinopsis' => 'Kisah persahabatan dan keluarga lima anak muda di lingkungan Seoul pada tahun 1988.',
                        'cast' => ['Lee Hye-ri', 'Park Bo-gum', 'Ryu Jun-yeol']
                    ],
                ];
            @endphp

            @foreach ($dramas as $drama)
                <div class="drama-card">
                    <img class="poster" src="{{ asset('images/dramas/' . $drama['poster']) }}" alt="{{ $drama['title'] }}" loading="lazy">
                    <span class="badge-top {{ $drama['badge_class'] }}">{{ $drama['badge'] }}</span>
                    <div class="info">
                        <h3>{{ $drama['title'] }}</h3>
                        <div class="meta">
                            <span>{{ $drama['year'] }}</span>
                            <span>•</span>
                            <span class="rating">⭐ {{ $drama['rating'] }}</span>
                            <span>•</span>
                            <span>{{ $drama['episodes'] }} Episode</span>
                        </div>
                        <div class="genres">
                            @foreach ($drama['genres'] as $genre)
                                <span>{{ $genre }}</span>
                            @endforeach
                        </div>
                        <p class="sinopsis">{{ $drama['sinopsis'] }}</p>
                        <div class="pemeran">
                            @foreach ($drama['cast'] as $actor)
                                <span>{{ $actor }}</span>
                            @endforeach
                        </div>
                        <div class="episode-info">
                            <span>📺 {{ $drama['episodes'] }} Episode</span>
                            <span>⭐ {{ $drama['rating'] }}/10</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            <button class="pagination-btn">← Sebelumnya</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn-number">2</button>
            <button class="pagination-btn-number">3</button>
            <button class="pagination-btn">Selanjutnya →</button>
        </div>
    </section>

    <!-- ARTIKEL -->
    <section class="section" id="artikel">
        <div class="section-header">
            <span class="tag">📰 Terbaru</span>
            <h2>Artikel <span class="highlight">Drama Korea</span></h2>
            <p>Berita, review, dan informasi menarik seputar drama Korea</p>
        </div>

        <!-- Filter Artikel -->
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

        <div class="article-grid">
            @php
                $artikels = [
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

            @foreach ($artikels as $artikel)
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