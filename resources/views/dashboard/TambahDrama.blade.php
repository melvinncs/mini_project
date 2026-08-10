@extends('dashboard.layout')

@section('title', 'Tambah Drama')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Tambah Drama Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.drama.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="position: relative;">
                <label for="cari_drama">Cari Judul K-Drama</label>
                <input type="text" id="cari_drama" class="form-control" placeholder="Ketik judul drama, contoh: Crash Landing on You" autocomplete="off">
                <div id="hasil_pencarian" style="position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 1px solid #E4E4E7; border-radius: 8px; max-height: 300px; overflow-y: auto; z-index: 20; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.08);"></div>
            </div>

            <!-- TAMBAHKAN INI: Hidden input untuk judul -->
            <input type="hidden" id="judul" name="judul">
            <input type="hidden" id="tmdb_poster_url" name="tmdb_poster_url">

            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" class="form-control" placeholder="Contoh: Romance, Comedy, Thriller" value="{{ old('genre') }}">
                @error('genre')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" id="tahun" name="tahun" class="form-control" placeholder="2024" value="{{ old('tahun') }}" min="1900" max="{{ date('Y') }}">
                    @error('tahun')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="episode">Jumlah Episode</label>
                    <input type="number" id="episode" name="episode" class="form-control" placeholder="16" value="{{ old('episode') }}" min="1">
                    @error('episode')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rating">Rating</label>
                    <input type="text" id="rating" name="rating" class="form-control" placeholder="8.5" value="{{ old('rating') }}">
                    @error('rating')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="Ongoing">Ongoing</option>
                    <option value="Completed">Completed</option>
                    <option value="Upcoming">Upcoming</option>
                    <option value="On Hold">On Hold</option>
                </select>
                @error('status')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pemeran_utama">Pemeran Utama</label>
                <input type="text" id="pemeran_utama" name="pemeran_utama" class="form-control" placeholder="Contoh: Kim Soo-hyun, Kim Ji-won" value="{{ old('pemeran_utama') }}">
                @error('pemeran_utama')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, JPEG, PNG (Max 2MB)</small>
                @error('thumbnail')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sinopsis">Sinopsis</label>
                <textarea id="sinopsis" name="sinopsis" class="form-control" rows="8" placeholder="Tulis sinopsis drama di sini...">{{ old('sinopsis') }}</textarea>
                @error('sinopsis')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard.drama') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Drama</button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const inputCari = document.getElementById('cari_drama');
    const kotakHasil = document.getElementById('hasil_pencarian');
    let waktuTunggu;

    inputCari.addEventListener('input', function () {
        clearTimeout(waktuTunggu);
        const kataKunci = this.value.trim();

        if (kataKunci.length < 2) {
            kotakHasil.style.display = 'none';
            return;
        }

        waktuTunggu = setTimeout(() => {
            fetch(`{{ route('dashboard.drama.cari') }}?query=${encodeURIComponent(kataKunci)}`)
                .then(res => res.json())
                .then(data => tampilkanHasil(data))
                .catch(() => { kotakHasil.style.display = 'none'; });
        }, 400);
    });

    function tampilkanHasil(data) {
        if (!data.length) {
            kotakHasil.innerHTML = '<div style="padding:12px; color:#A1A1AA;">Tidak ditemukan</div>';
            kotakHasil.style.display = 'block';
            return;
        }

        kotakHasil.innerHTML = data.map(item => `
            <div class="item-hasil" data-id="${item.id}" style="display:flex; gap:10px; padding:8px 12px; cursor:pointer; align-items:center; border-bottom:1px solid #F4F4F5;">
                <img src="${item.poster ?? ''}" onerror="this.style.display='none'" style="width:36px; height:52px; object-fit:cover; border-radius:4px; background:#E4E4E7;">
                <div>
                    <div style="font-weight:600;">${item.judul}</div>
                    <div style="font-size:12px; color:#A1A1AA;">${item.tahun || '-'}</div>
                </div>
            </div>
        `).join('');

        kotakHasil.style.display = 'block';

        document.querySelectorAll('.item-hasil').forEach(el => {
            el.addEventListener('click', function () {
                ambilDetail(this.dataset.id);
                kotakHasil.style.display = 'none';
            });
            el.addEventListener('mouseenter', function () { this.style.background = '#F8F8FA'; });
            el.addEventListener('mouseleave', function () { this.style.background = ''; });
        });
    }

    function ambilDetail(id) {
        console.log('Mengambil detail untuk ID:', id);

        fetch(`/dashboard/drama/tmdb/${id}`)
            .then(res => {
                if (!res.ok) {
                    throw new Error(`Server merespon status ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Data diterima:', data);

                if (data.error) {
                    alert('Gagal ambil detail: ' + data.error);
                    return;
                }

                // TAMBAHKAN INI: Set value ke hidden input judul
                document.getElementById('judul').value = data.judul || '';
                document.getElementById('genre').value = data.genre || '';
                document.getElementById('tahun').value = data.tahun || '';
                document.getElementById('episode').value = data.episode || '';
                document.getElementById('rating').value = data.rating || '';
                document.getElementById('sinopsis').value = data.sinopsis || '';
                document.getElementById('pemeran_utama').value = data.pemeran_utama || '';
                document.getElementById('tmdb_poster_url').value = data.poster_url || '';
                inputCari.value = data.judul;

                tampilkanPreviewThumbnail(data.poster_url);
            })
            .catch(err => {
                console.error('Gagal mengambil detail drama:', err);
                alert('Terjadi kesalahan saat mengambil detail drama. Cek console untuk detail.');
            });
    }

    function tampilkanPreviewThumbnail(url) {
        let previewLama = document.getElementById('preview_thumbnail_tmdb');
        if (previewLama) previewLama.remove();

        if (!url) return;

        const groupThumbnail = document.getElementById('thumbnail').closest('.form-group');
        const gambar = document.createElement('img');
        gambar.id = 'preview_thumbnail_tmdb';
        gambar.src = url;
        gambar.style.cssText = 'width:120px; height:160px; object-fit:cover; border-radius:8px; margin-bottom:10px; display:block;';
        groupThumbnail.insertBefore(gambar, groupThumbnail.firstChild.nextSibling);
    }

    document.addEventListener('click', function (e) {
        if (!kotakHasil.contains(e.target) && e.target !== inputCari) {
            kotakHasil.style.display = 'none';
        }
    });
})();
</script>
@endsection