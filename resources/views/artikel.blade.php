@extends('layouts.app')

@section('content')
    <!-- ARTIKEL PAGE -->
    <section class="section" id="artikel">
        <div class="section-header">
            <span class="tag">📰 Koleksi</span>
            <h2>Semua <span class="highlight">Artikel</span></h2>
            <p>Kumpulan artikel, berita, dan review drama Korea</p>
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
                <a href="{{ route('artikel.detail', $artikel->slug) }}" class="article-card article-card-link" data-kategori="{{ $artikel->kategori ?? '' }}" aria-label="Baca artikel {{ $artikel->judul }}">
                    <img class="thumb"
                        src="{{ $artikel->thumbnail ? asset($artikel->thumbnail) : asset('images/default-article.jpg') }}"
                        alt="{{ $artikel->judul }}"
                        loading="lazy">
                    <div class="info">
                        <span class="category">{{ $artikel->kategori ?? 'Artikel' }}</span>
                        <h3>{{ $artikel->judul }}</h3>
                        <p>{{ Str::limit(strip_tags($artikel->isi), 150) }}</p>
                        <div class="author">
                            <div>
                                <div class="name">{{ $artikel->pengguna->nama ?? 'Admin' }}</div>
                                <div class="date">{{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : 'Belum dipublikasi' }}</div>
                            </div>
                        </div>
                        <span class="read-more">Baca Selengkapnya →</span>
                    </div>
                </a>
            @empty
                <div class="no-articles" style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <p style="font-size: 18px; color: var(--text-gray);">Belum ada artikel.</p>
                </div>
            @endforelse
        </div>

        @if ($artikels->hasPages())
            <nav class="pagination-wrapper" aria-label="Pagination artikel">
                @if ($artikels->onFirstPage())
                    <span class="pagination-btn" aria-disabled="true">← Sebelumnya</span>
                @else
                    <a href="{{ $artikels->previousPageUrl() }}" class="pagination-btn" rel="prev">← Sebelumnya</a>
                @endif

                @foreach ($artikels->getUrlRange(1, $artikels->lastPage()) as $halaman => $url)
                    <a href="{{ $url }}" class="pagination-btn{{ $halaman === $artikels->currentPage() ? ' active' : '' }}" @if ($halaman === $artikels->currentPage()) aria-current="page" @endif>
                        {{ $halaman }}
                    </a>
                @endforeach

                @if ($artikels->hasMorePages())
                    <a href="{{ $artikels->nextPageUrl() }}" class="pagination-btn" rel="next">Berikutnya →</a>
                @else
                    <span class="pagination-btn" aria-disabled="true">Berikutnya →</span>
                @endif
            </nav>
        @endif
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchArtikel');
    const kategoriFilter = document.getElementById('kategoriFilter');
    const filterBtn = document.getElementById('filterArtikelBtn');
    const articleGrid = document.getElementById('articleGrid');
    
    function filterArticles() {
        const keyword = searchInput.value.toLowerCase();
        const kategori = kategoriFilter.value.toLowerCase();
        
        const cards = articleGrid.querySelectorAll('.article-card-link');
        let hasResults = false;
        
        cards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const desc = card.querySelector('p').textContent.toLowerCase();
            const cardKategori = card.dataset.kategori?.toLowerCase() || '';
            
            let show = true;
            
            if (keyword && !title.includes(keyword) && !desc.includes(keyword)) {
                show = false;
            }
            
            if (kategori && cardKategori !== kategori) {
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
                noResult.style.gridColumn = '1/-1';
                noResult.style.textAlign = 'center';
                noResult.style.padding = '40px';
                noResult.style.color = 'var(--text-gray)';
                noResult.innerHTML = '<p>Tidak ada artikel yang ditemukan.</p>';
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