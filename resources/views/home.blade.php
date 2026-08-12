@extends('layouts.app')

@section('content')
    <!-- HOME -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badges">
                    <span class="hero-badge"><span class="dot"></span> {{ $landing->hero_badge_1 }}</span>
                    <span class="hero-badge">{{ $landing->hero_badge_2 }}</span>
                    <span class="hero-badge">{{ $landing->hero_badge_3 }}</span>
                </div>

                <h1>
                    {{ $landing->hero_title_line1 }} <span class="highlight">{{ $landing->hero_title_highlight }}</span><br>
                    {{ $landing->hero_title_line2 }}
                </h1>

                <p>{{ $landing->hero_description }}</p>

                <div class="hero-cta">
                    <a href="#drama" class="btn-primary">{{ $landing->hero_btn_primary_text }}</a>
                    <a href="#artikel" class="btn-secondary">{{ $landing->hero_btn_secondary_text }}</a>
                </div>
            </div>

            <div class="hero-image">
                <div class="hero-image-wrapper">
                    <div class="circle-bg"></div>
                    <img src="{{ $landing->hero_image ? asset($landing->hero_image) : asset('image/home.png') }}" alt="{{ $landing->footer_brand_name }} Hero" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- DRAMA -->
    <section class="section" id="drama">
        <div class="section-header">
            <span class="tag">{{ $landing->drama_tag }}</span>
            <h2>{{ $landing->drama_title }}</h2>
            <p>{{ $landing->drama_desc }}</p>
        </div>

        <!-- Filter Drama -->
        <form class="filter-wrapper" action="{{ route('home') }}#drama" method="GET">
            <input type="text" name="drama_cari" value="{{ request('drama_cari') }}" placeholder="Cari drama..." class="filter-input" id="searchDrama">
            <select class="filter-select" id="genreFilter" name="drama_genre">
                <option value="">Semua Genre</option>
                <option value="Aksi & Petualangan" @selected(request('drama_genre') === 'Aksi & Petualangan')>Aksi & Petualangan</option>
                <option value="Animasi" @selected(request('drama_genre') === 'Animasi')>Animasi</option>
                <option value="Drama" @selected(request('drama_genre') === 'Drama')>Drama</option>
                <option value="Komedi" @selected(request('drama_genre') === 'Komedi')>Komedi</option>
                <option value="Kejahatan" @selected(request('drama_genre') === 'Kejahatan')>Kejahatan</option>
                <option value="Misteri" @selected(request('drama_genre') === 'Misteri')>Misteri</option>
                <option value="Romantis" @selected(request('drama_genre') === 'Romantis')>Romantis</option>
            </select>
            <select class="filter-select" id="tahunFilter" name="drama_tahun">
                <option value="">Semua Tahun</option>
                @foreach(range(date('Y'), 2020) as $tahun)
                    <option value="{{ $tahun }}" @selected((string) request('drama_tahun') === (string) $tahun)>{{ $tahun }}</option>
                @endforeach
            </select>
            <button type="submit" class="filter-btn" id="filterDramaBtn">Cari</button>
        </form>

        <div class="drama-grid-dashboard" id="dramaGrid">
            @forelse($dramas as $drama)
                <a href="{{ route('drama.detail', $drama->slug) }}" class="drama-card-dashboard drama-card-link" data-genre="{{ $drama->genre ?? '' }}" data-tahun="{{ $drama->tahun ?? '' }}" aria-label="Lihat detail drama {{ $drama->judul }}">
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
                </a>
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
            <span class="tag">{{ $landing->artikel_tag }}</span>
            <h2>{{ $landing->artikel_title }}</h2>
            <p>{{ $landing->artikel_desc }}</p>
        </div>

        <!-- Filter Artikel -->
        <form class="filter-wrapper" action="{{ route('home') }}#artikel" method="GET">
            <input type="text" name="artikel_cari" value="{{ request('artikel_cari') }}" placeholder="Cari artikel..." class="filter-input" id="searchArtikel">
            <select class="filter-select" id="kategoriFilter" name="artikel_kategori">
                <option value="">Semua Kategori</option>
                <option value="Review" @selected(request('artikel_kategori') === 'Review')>Review</option>
                <option value="Rekomendasi" @selected(request('artikel_kategori') === 'Rekomendasi')>Rekomendasi</option>
                <option value="Pemeran" @selected(request('artikel_kategori') === 'Pemeran')>Pemeran</option>
                <option value="Perbandingan" @selected(request('artikel_kategori') === 'Perbandingan')>Perbandingan</option>
                <option value="OST" @selected(request('artikel_kategori') === 'OST')>OST</option>
                <option value="Preview" @selected(request('artikel_kategori') === 'Preview')>Preview</option>
                <option value="Berita" @selected(request('artikel_kategori') === 'Berita')>Berita</option>
            </select>
            <button type="submit" class="filter-btn" id="filterArtikelBtn">Cari</button>
        </form>

        <div class="article-grid" id="articleGrid">
            @forelse($artikels as $artikel)
                <a href="{{ route('artikel.detail', $artikel->slug) }}" class="article-card article-card-link" data-kategori="{{ $artikel->kategori ?? '' }}" aria-label="Baca artikel {{ $artikel->judul }}">
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
                    </div>
                </a>
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
    const searchDrama = document.getElementById('searchDrama');
    const genreFilter = document.getElementById('genreFilter');
    const tahunFilter = document.getElementById('tahunFilter');
    const filterDramaBtn = document.getElementById('filterDramaBtn');
    const dramaGrid = document.getElementById('dramaGrid');

    const kategoriFilter = document.getElementById('kategoriFilter');
    const searchArtikel = document.getElementById('searchArtikel');
    const filterArtikelBtn = document.getElementById('filterArtikelBtn');
    const articleGrid = document.getElementById('articleGrid');

    function toggleNoResult(grid, hasResults, message) {
        let noResult = grid.querySelector('.no-result');

        if (!hasResults && !noResult) {
            noResult = document.createElement('div');
            noResult.className = 'no-result';
            noResult.style.cssText = 'grid-column: 1/-1; text-align: center; padding: 40px; color: var(--text-gray);';
            noResult.innerHTML = `<p>${message}</p>`;
            grid.appendChild(noResult);
        } else if (hasResults && noResult) {
            noResult.remove();
        }
    }

    function filterDramas() {
        const keyword = searchDrama.value.trim().toLowerCase();
        const genre = genreFilter.value.toLowerCase();
        const tahun = tahunFilter.value;
        let hasResults = false;

        dramaGrid.querySelectorAll('.drama-card-dashboard').forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const synopsis = card.querySelector('.sinopsis')?.textContent.toLowerCase() || '';
            const cardGenre = card.dataset.genre.toLowerCase();
            const cardTahun = card.dataset.tahun;
            const show = (!keyword || title.includes(keyword) || synopsis.includes(keyword))
                && (!genre || cardGenre.includes(genre))
                && (!tahun || cardTahun === tahun);

            card.style.display = show ? '' : 'none';
            hasResults ||= show;
        });

        toggleNoResult(dramaGrid, hasResults, 'Tidak ada drama yang ditemukan.');
    }

    function filterArticles() {
        const keyword = searchArtikel.value.trim().toLowerCase();
        const kategori = kategoriFilter.value.toLowerCase();
        let hasResults = false;

        articleGrid.querySelectorAll('.article-card').forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const desc = card.querySelector('p').textContent.toLowerCase();
            const cardKategori = card.dataset.kategori.toLowerCase();
            const show = (!keyword || title.includes(keyword) || desc.includes(keyword))
                && (!kategori || cardKategori === kategori);

            card.style.display = show ? '' : 'none';
            hasResults ||= show;
        });

        toggleNoResult(articleGrid, hasResults, 'Tidak ada artikel yang ditemukan.');
    }

    filterDramaBtn?.addEventListener('click', filterDramas);
    filterArtikelBtn?.addEventListener('click', filterArticles);
    searchDrama?.addEventListener('keydown', event => {
        if (event.key === 'Enter') filterDramas();
    });
    searchArtikel?.addEventListener('keydown', event => {
        if (event.key === 'Enter') filterArticles();
    });
});
</script>
@endsection
