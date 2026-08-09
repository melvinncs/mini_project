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
            <button class="filter-btn" id="filterArtikelBtn">🔍 Cari</button>
        </div>

        <div class="article-grid" id="articleGrid">
            @forelse($artikels ?? [] as $artikel)
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
                    <p>Belum ada artikel. Silakan buat artikel di dashboard.</p>
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
    fetchDramas();
});

async function fetchDramas() {
    const searchInput = document.querySelector('.filter-input');
    const yearSelect = document.querySelector('.filter-select:last-child');
    const genreSelect = document.querySelector('.filter-select:nth-child(2)');
    const searchBtn = document.querySelector('.filter-btn');
    const dramaGrid = document.querySelector('.drama-grid');
    
    // Show loading state
    if (dramaGrid) {
        dramaGrid.innerHTML = '<div class="loading">Loading dramas...</div>';
    }
    
    async function loadDramas() {
        try {
            const query = searchInput ? searchInput.value.trim() || 'korean drama' : 'korean drama';
            const year = yearSelect ? yearSelect.value || '2026' : '2026';
            
            const response = await fetch(`/api/dramas?q=${encodeURIComponent(query)}&year=${year}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Failed to fetch dramas');
            }
            
            renderDramas(data.data);
            
            // Update total count
            const totalElement = document.querySelector('.total-dramas');
            if (totalElement) {
                totalElement.textContent = `Total: ${data.total} dramas`;
            }
            
        } catch (error) {
            console.error('Error fetching dramas:', error);
            if (dramaGrid) {
                dramaGrid.innerHTML = `
                    <div class="error-message">
                        <p>Failed to load dramas: ${error.message}</p>
                        <button onclick="fetchDramas()" class="btn-primary">Retry</button>
                    </div>
                `;
            }
        }
    }
    
    function renderDramas(dramas) {
        if (!dramaGrid) return;
        
        if (dramas.length === 0) {
            dramaGrid.innerHTML = '<div class="no-results">No dramas found for the selected criteria.</div>';
            return;
        }
        
        let html = '';
        dramas.forEach(drama => {
            const genres = drama.genres || [];
            const rating = drama.rating ? drama.rating.toFixed(1) : 'N/A';
            const poster = drama.poster || '/images/placeholder.jpg';
            
            html += `
                <div class="drama-card">
                    <img class="poster" src="${poster}" alt="${drama.title}" loading="lazy" 
                         onerror="this.src='/images/placeholder.jpg'">
                    ${drama.status === 'Ended' ? '<span class="badge-top badge-ended">Selesai</span>' : ''}
                    <div class="info">
                        <h3>${drama.title}</h3>
                        <div class="meta">
                            <span>${drama.year || 'N/A'}</span>
                            <span>•</span>
                            <span class="rating">⭐ ${rating}</span>
                            <span>•</span>
                            <span>${drama.episodes || 0} Episode</span>
                        </div>
                        <div class="genres">
                            ${genres.map(g => `<span>${g}</span>`).join('')}
                        </div>
                        <p class="sinopsis">${drama.summary || 'No synopsis available'}</p>
                        <div class="pemeran">
                            ${drama.cast && drama.cast.length > 0 
                                    ? drama.cast.slice(0, 3).map(actor => 
                                    `<span>${actor.name}${actor.character ? ` as ${actor.character}` : ''}</span>`
                                    ).join('')
                                : '<span>Cast information not available</span>'
                            }
                        </div>
                        <div class="episode-info">
                            <span>📺 ${drama.episodes || 0} Episode</span>
                            <span>⭐ ${rating}/10</span>
                        </div>
                    </div>
                </div>
            `;
        });
        
        dramaGrid.innerHTML = html;
    }
    
    // Load initial dramas
    await loadDramas();
    
    // Add event listeners
    if (searchBtn) {
        searchBtn.addEventListener('click', loadDramas);
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                loadDramas();
            }
        });
    }
    
    if (yearSelect) {
        yearSelect.addEventListener('change', loadDramas);
    }
}
</script>

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