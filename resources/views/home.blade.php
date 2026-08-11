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
            <span class="tag">Trending Now</span>
            <h2>Drama <span class="highlight">Terbaru</span></h2>
            <p>Drama Korea terbaru yang sedang populer</p>
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
            <button class="filter-btn">Cari</button>
        </div>

        <div class="drama-grid-dashboard">
            @forelse($dramas as $drama)
                <div class="drama-card-dashboard">
                    <div class="poster-wrapper">
                        @if($drama->thumbnail)
                            <img src="{{ asset($drama->thumbnail) }}" alt="{{ $drama->judul }}" loading="lazy">
                        @else
                            <img src="{{ asset('images/placeholder.jpg') }}" alt="Placeholder" loading="lazy">
                        @endif
                        
                        @if($drama->status)
                            <span class="badge-top 
                                @if($drama->status == 'Ongoing') badge-ongoing
                                @elseif($drama->status == 'Completed') badge-completed
                                @elseif($drama->status == 'Upcoming') badge-upcoming
                                @elseif($drama->status == 'On Hold') badge-hold
                                @else badge-hot
                                @endif
                            ">
                                {{ $drama->status }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="info">
                        <h3>{{ $drama->judul }}</h3>
                        
                        <div class="meta">
                            <span> {{ $drama->tahun ?? 'N/A' }}</span>
                            <span>•</span>
                            <span class="rating"> {{ $drama->rating ?? 'N/A' }}</span>
                            <span>•</span>
                            <span> {{ $drama->episode ?? 0 }} Ep</span>
                        </div>
                        
                        @if($drama->genre)
                            <div class="genres">
                                @foreach(explode(',', $drama->genre) as $genre)
                                    <span>{{ trim($genre) }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        @if($drama->sinopsis)
                            <p class="sinopsis">{{ Str::limit($drama->sinopsis, 100) }}</p>
                        @endif
                        
                        @if($drama->pemeran_utama)
                            <div class="pemeran">
                                @foreach(explode(',', $drama->pemeran_utama) as $actor)
                                    <span>{{ trim($actor) }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="episode-info">
                            <span> {{ $drama->episode ?? 0 }} Episode</span>
                            <span> {{ $drama->rating ?? 'N/A' }}/10</span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <p style="font-size: 18px; color: var(--text-gray);">Belum ada drama.</p>
                </div>
            @endforelse
        </div>

        <div class="section-footer">
            <a href="{{ route('drama') }}" class="btn-primary">Lihat Semua Drama →</a>
        </div>
    </section>

    <!-- ARTIKEL -->
    <section class="section" id="artikel">
        <div class="section-header">
            <span class="tag"> Terbaru</span>
            <h2>Artikel <span class="highlight">Drama Korea</span></h2>
            <p>Berita, review, dan informasi menarik seputar drama Korea</p>
        </div>

        <!-- Filter Artikel -->
        <div class="filter-wrapper">
            <input type="text" placeholder="Cari artikel..." class="filter-input" id="searchArtikel">
            <select class="filter-select" id="kategoriFilter">
                <option value="">Semua Kategori</option>
                <option value="Review">Review</option>
                <option value="Rekomendasi">Rekomendasi</option>
                <option value="Pemeran">Pemeran</option>
                <option value="Perbandingan">Perbandingan</option>
                <option value="OST">OST</option>
                <option value="Preview">Preview</option>
                <option value="Berita">Berita</option>
            </select>
            <button class="filter-btn" id="filterArtikelBtn">Cari</button>
        </div>

        <div class="article-grid" id="articleGrid">
            @forelse($artikels as $artikel)
                <div class="article-card">
                    <img class="thumb"
                        src="{{ $artikel->thumbnail ? asset($artikel->thumbnail) : asset('images/default-article.jpg') }}"
                        alt="{{ $artikel->judul }}"
                        loading="lazy">
                    <div class="info">
                        <span class="category">{{ $artikel->kategori ?? 'Artikel' }}</span>
                        <h3>{{ $artikel->judul }}</h3>
                        <p>{{ Str::limit(strip_tags($artikel->isi), 120) }}</p>
                        <div class="author">
                            <!-- <img src="{{ asset('images/authors/default-avatar.jpg') }}" 
                                alt="{{ $artikel->pengguna->nama ?? 'Penulis' }}" loading="lazy"> -->
                            <div>
                                <div class="name">{{ $artikel->pengguna->nama ?? 'Admin' }}</div>
                                <div class="date">{{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : 'Belum dipublikasi' }}</div>
                            </div>
                        </div>
                        <a href="{{ route('artikel.detail', $artikel->slug) }}" class="read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
            @empty
                <div class="no-articles">
                    <p>Belum ada artikel.</p>
                </div>
            @endforelse
        </div>

        <div class="section-footer">
            <a href="{{ route('artikel') }}" class="btn-primary">Baca Semua Artikel →</a>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter Artikel
    const searchInput = document.getElementById('searchArtikel');
    const kategoriFilter = document.getElementById('kategoriFilter');
    const filterBtn = document.getElementById('filterArtikelBtn');
    const articleGrid = document.getElementById('articleGrid');
    
    function filterArticles() {
        const keyword = searchInput.value.toLowerCase();
        const kategori = kategoriFilter.value;
        
        const cards = articleGrid.querySelectorAll('.article-card');
        let hasResults = false;
        
        cards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const desc = card.querySelector('p').textContent.toLowerCase();
            const category = card.querySelector('.category').textContent.toLowerCase();
            
            let show = true;
            
            if (keyword && !title.includes(keyword) && !desc.includes(keyword)) {
                show = false;
            }
            
            if (kategori && category !== kategori.toLowerCase()) {
                show = false;
            }
            
            card.style.display = show ? 'block' : 'none';
            if (show) hasResults = true;
        });
        
        // Show no results message
        let noResult = articleGrid.querySelector('.no-result');
        if (!hasResults) {
            if (!noResult) {
                noResult = document.createElement('div');
                noResult.className = 'no-result';
                noResult.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-gray);">Tidak ada artikel yang ditemukan.</p>';
                articleGrid.appendChild(noResult);
            }
        } else if (noResult) {
            noResult.remove();
        }
    }
    
    if (filterBtn) {
        filterBtn.addEventListener('click', filterArticles);
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterArticles();
            }
        });
    }
});
</script>
@endsection