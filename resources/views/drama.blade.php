@extends('layouts.app')

@section('title', 'Drama Korea - K-DramaHub')

@section('content')
    <section class="section" id="drama" style="padding-top: 120px;">
        <div class="section-header">
            <span class="tag">📺 Koleksi Lengkap</span>
            <h2>Semua <span class="highlight">Drama Korea</span></h2>
            <p>Temukan berbagai drama Korea dari berbagai genre dan tahun</p>
        </div>

        <!-- Filter / Pencarian -->
        <div class="filter-wrapper">
            <input type="text" placeholder="Cari drama..." class="filter-input">
            <select class="filter-select">
                <option value="">Semua Genre</option>
                <option value="Romance">Romance</option>
                <option value="Drama">Drama</option>
                <option value="Thriller">Thriller</option>
                <option value="Komedi">Komedi</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Action">Action</option>
                <option value="Medis">Medis</option>
                <option value="Survival">Survival</option>
            </select>
            <select class="filter-select">
                <option value="">Semua Tahun</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
            </select>
            <button class="filter-btn">🔍 Cari</button>
        </div>

        <!-- Grid Drama -->
        <div class="drama-grid">
            @php
                $allDramas = [
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

            @foreach ($allDramas as $drama)
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
@endsection