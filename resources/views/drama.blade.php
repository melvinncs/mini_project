@extends('layouts.app')

@section('content')
    <!-- DRAMA PAGE -->
    <section class="section" id="drama">
        <div class="section-header">
            <span class="tag">🎬 Koleksi</span>
            <h2>Semua <span class="highlight">Drama Korea</span></h2>
            <p>Daftar lengkap drama Korea yang tersedia</p>
        </div>

        <!-- Filter Drama -->
        <div class="filter-wrapper">
            <input type="text" placeholder="Cari drama..." class="filter-input" id="searchDrama">
            <select class="filter-select" id="genreFilter">
                <option value="">Semua Genre</option>
                <option value="Romance">Romance</option>
                <option value="Drama">Drama</option>
                <option value="Thriller">Thriller</option>
                <option value="Comedy">Comedy</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Action">Action</option>
            </select>
            <select class="filter-select" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Completed">Completed</option>
                <option value="Upcoming">Upcoming</option>
                <option value="On Hold">On Hold</option>
            </select>
            <button class="filter-btn" id="filterDramaBtn">Cari</button>
        </div>

        <div class="drama-grid-dashboard" id="dramaGrid">
            @forelse($dramas as $drama)
                <div class="drama-card-dashboard" data-genre="{{ $drama->genre }}" data-status="{{ $drama->status }}">
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
                            <span>📅 {{ $drama->tahun ?? 'N/A' }}</span>
                            <span>•</span>
                            <span class="rating">⭐ {{ $drama->rating ?? 'N/A' }}</span>
                            <span>•</span>
                            <span>📺 {{ $drama->episode ?? 0 }} Ep</span>
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
                            <span>📺 {{ $drama->episode ?? 0 }} Episode</span>
                            <span>⭐ {{ $drama->rating ?? 'N/A' }}/10</span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <p style="font-size: 18px; color: var(--text-gray);">Belum ada drama.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchDrama');
    const genreFilter = document.getElementById('genreFilter');
    const statusFilter = document.getElementById('statusFilter');
    const filterBtn = document.getElementById('filterDramaBtn');
    const dramaGrid = document.getElementById('dramaGrid');
    
    function filterDramas() {
        const keyword = searchInput.value.toLowerCase();
        const genre = genreFilter.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        
        const cards = dramaGrid.querySelectorAll('.drama-card-dashboard');
        let hasResults = false;
        
        cards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const cardGenre = card.dataset.genre?.toLowerCase() || '';
            const cardStatus = card.dataset.status?.toLowerCase() || '';
            
            let show = true;
            
            if (keyword && !title.includes(keyword)) {
                show = false;
            }
            
            if (genre && !cardGenre.includes(genre)) {
                show = false;
            }
            
            if (status && cardStatus !== status) {
                show = false;
            }
            
            card.style.display = show ? 'block' : 'none';
            if (show) hasResults = true;
        });
        
        // Show no results message
        let noResult = dramaGrid.querySelector('.no-result');
        if (!hasResults) {
            if (!noResult) {
                noResult = document.createElement('div');
                noResult.className = 'no-result';
                noResult.style.gridColumn = '1/-1';
                noResult.style.textAlign = 'center';
                noResult.style.padding = '40px';
                noResult.style.color = 'var(--text-gray)';
                noResult.innerHTML = '<p>Tidak ada drama yang ditemukan.</p>';
                dramaGrid.appendChild(noResult);
            }
        } else if (noResult) {
            noResult.remove();
        }
    }
    
    if (filterBtn) {
        filterBtn.addEventListener('click', filterDramas);
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterDramas();
            }
        });
    }
});
</script>
@endsection