{{-- resources/views/dashboard/artikel-create.blade.php --}}
@extends('dashboard.layout')

@section('title', 'Buat Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Buat Artikel Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan judul artikel" required>
                @error('judul')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Review">Review</option>
                    <option value="Rekomendasi">Rekomendasi</option>
                    <option value="Pemeran">Pemeran</option>
                    <option value="Perbandingan">Perbandingan</option>
                    <option value="OST">OST</option>
                    <option value="Preview">Preview</option>
                    <option value="Berita">Berita</option>
                </select>

                @error('kategori')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                @error('thumbnail')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="isi">Konten</label>
                <textarea id="isi" name="isi" class="form-control" rows="10" placeholder="Tulis konten artikel di sini..." required></textarea>
                @error('isi')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard.artikel') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Publikasikan</button>
            </div>
        </form>
    </div>
</div>
@endsection