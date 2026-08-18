@extends('dashboard.layout')

@section('title', 'Tambah Drama Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Tambah Drama Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.drama.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="position: relative;">
                <label for="cari_drama">Cari Judul K-Drama</label>
                <input type="text" id="cari_drama" class="form-control" placeholder="Ketik judul drama, contoh: Crash Landing on You" autocomplete="off">
                <div id="hasil_pencarian" style="position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 1px solid #E4E4E7; border-radius: 8px; max-height: 300px; overflow-y: auto; z-index: 20; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.08);"></div>
            </div>

            <input type="hidden" id="judul" name="judul">
            <input type="hidden" id="tmdb_poster_url" name="tmdb_poster_url">

            <div class="form-group">
                <label for="judul_display">Judul</label>
                <input type="text" id="judul_display" class="form-control" placeholder="Judul akan muncul setelah mencari" readonly>
            </div>

            <div class="form-group">
                <label for="pemeran_utama">Pemeran Utama</label>
                <input type="text" id="pemeran_utama" name="pemeran_utama" class="form-control" placeholder="Contoh: Hyun Bin, Son Ye-jin">
            </div>

            <div class="form-group">
                <label for="sinopsis">Sinopsis</label>
                <textarea id="sinopsis" name="sinopsis" class="form-control" rows="4" placeholder="Sinopsis akan muncul setelah mencari"></textarea>
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" class="form-control" placeholder="Contoh: Romantis, Komedi, Thriller">
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" id="tahun" name="tahun" class="form-control" placeholder="2024">
                </div>
                <div class="form-group">
                    <label for="episode">Episode</label>
                    <input type="number" id="episode" name="episode" class="form-control" placeholder="16">
                </div>
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <input type="number" id="rating" name="rating" class="form-control" placeholder="8.5" step="0.1">
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                    <option value="Upcoming">Upcoming</option>
                </select>
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                <div id="thumbnail_preview" style="margin-top: 10px;"></div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.drama') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Drama</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('cari_drama');
    const resultsDiv = document.getElementById('hasil_pencarian');
    const judulHidden = document.getElementById('judul');
    const judulDisplay = document.getElementById('judul_display');
    const sinopsisTextarea = document.getElementById('sinopsis');
    const genreInput = document.getElementById('genre');
    const tahunInput = document.getElementById('tahun');
    const episodeInput = document.getElementById('episode');
    const ratingInput = document.getElementById('rating');
    const pemeranInput = document.getElementById('pemeran_utama');
    const posterUrlHidden = document.getElementById('tmdb_poster_url');
    const thumbnailPreview = document.getElementById('thumbnail_preview');

    let searchTimeout;

    // Event listener untuk input pencarian
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            resultsDiv.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            searchDramas(query);
        }, 500);
    });

    // Fungsi untuk mencari drama dari TMDB
    async function searchDramas(query) {
        try {
            const response = await fetch(`/admin/drama/cari?q=${encodeURIComponent(query)}`);
            const json = await response.json();

            if (json.success && json.data.length > 0) {
                renderResults(json.data);
            } else {
                resultsDiv.innerHTML = `<div style="padding: 12px; color: #6B7280;">Tidak ada hasil ditemukan</div>`;
                resultsDiv.style.display = 'block';
            }
        } catch (error) {
            console.error('Error searching dramas:', error);
            resultsDiv.innerHTML = `<div style="padding: 12px; color: #EF4444;">Terjadi kesalahan saat mencari drama</div>`;
            resultsDiv.style.display = 'block';
        }
    }

    // Fungsi untuk menampilkan hasil pencarian
    function renderResults(dramas) {
        let html = '';
        dramas.forEach(drama => {
            html += `
                <div class="result-item" data-id="${drama.id}" style="display:flex; gap:10px; padding:8px 12px; cursor:pointer; align-items:center; border-bottom:1px solid #F4F4F5;">
                    ${drama.poster ? `<img src="${drama.poster}" alt="${drama.judul}" style="width: 40px; height: 60px; object-fit: cover; border-radius: 4px;">` : ''}
                    <div>
                        <div style="font-weight: 600;">${drama.judul}</div>
                        <div style="font-size: 12px; color: #6B7280;">${drama.year || 'Tahun tidak tersedia'}</div>
                    </div>
                </div>
            `;
        });
        
        resultsDiv.innerHTML = html;
        resultsDiv.style.display = 'block';

        document.querySelectorAll('.result-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.dataset.id;
                fetchDramaDetail(id);
            });

            item.addEventListener('mouseenter', function() {
                this.style.background = '#F9FAFB';
            });

            item.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
            });
        });
    }

    // Fungsi untuk mengambil detail drama dari TMDB
    async function fetchDramaDetail(id) {
        try {
            const response = await fetch(`/admin/drama/tmdb/${id}`);
            const json = await response.json();

            if (json.success && json.data) {
                const data = json.data;
                judulHidden.value = data.judul;
                judulDisplay.value = data.judul;
                sinopsisTextarea.value = data.sinopsis || '';
                genreInput.value = data.genre || '';
                tahunInput.value = data.tahun || '';
                episodeInput.value = data.episode || '';
                ratingInput.value = data.rating || '';
                pemeranInput.value = data.pemeran_utama || '';
                posterUrlHidden.value = data.poster_url || '';
                
                if (data.poster_url) {
                    thumbnailPreview.innerHTML = `
                        <img src="${data.poster_url}" alt="Poster" style="border-radius: 8px; max-height: 200px; max-width: 100%;">
                        <p class="text-muted" style="margin-top: 5px;">Poster dari TMDB</p>
                    `;
                } else {
                    thumbnailPreview.innerHTML = '';
                }

                resultsDiv.style.display = 'none';
                searchInput.value = data.judul;
            }
        } catch (error) {
            console.error('Error fetching drama detail:', error);
            resultsDiv.innerHTML = `<div style="padding: 12px; color: #EF4444;">Gagal mengambil detail drama</div>`;
            resultsDiv.style.display = 'block';
        }
    }

    // Tutup hasil pencarian saat klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.form-group')) {
            resultsDiv.style.display = 'none';
        }
    });

    // Preview thumbnail manual
    const thumbnailInput = document.getElementById('thumbnail');
    thumbnailInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailPreview.innerHTML = `
                    <img src="${e.target.result}" alt="Thumbnail" style="border-radius: 8px; max-height: 200px; max-width: 100%;">
                    <p class="text-muted" style="margin-top: 5px;">Thumbnail yang diupload</p>
                `;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<style>
.result-item:hover {
    background: #F9FAFB !important;
}

.text-muted {
    color: #6B7280;
    font-size: 12px;
}
</style>
@endpush
@endsection