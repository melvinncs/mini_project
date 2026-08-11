{{-- resources/views/dashboard/artikel-edit.blade.php --}}
@extends('dashboard.layout')

@section('title', 'Edit Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Artikel</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" id="judul" name="judul" class="form-control" value="{{ $artikel->judul }}" required>
                @error('judul')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Review" @selected(old('kategori', $artikel->kategori) === 'Review')>Review</option>
                    <option value="Rekomendasi" @selected(old('kategori', $artikel->kategori) === 'Rekomendasi')>Rekomendasi</option>
                    <option value="Pemeran" @selected(old('kategori', $artikel->kategori) === 'Pemeran')>Pemeran</option>
                    <option value="Perbandingan" @selected(old('kategori', $artikel->kategori) === 'Perbandingan')>Perbandingan</option>
                    <option value="OST" @selected(old('kategori', $artikel->kategori) === 'OST')>OST</option>
                    <option value="Preview" @selected(old('kategori', $artikel->kategori) === 'Preview')>Preview</option>
                    <option value="Berita" @selected(old('kategori', $artikel->kategori) === 'Berita')>Berita</option>
                </select>
                @error('kategori')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                @if($artikel->thumbnail)
                <div class="current-thumbnail">
                    <img src="{{ asset($artikel->thumbnail) }}" alt="Current Thumbnail" style="width: 200px; height: auto; border-radius: 8px;">
                    <p class="text-muted">Thumbnail saat ini</p>
                </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti thumbnail</small>
                @error('thumbnail')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="isi">Konten</label>
                <textarea id="isi" name="isi" class="form-control" rows="10" required>{{ $artikel->isi }}</textarea>
                @error('isi')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard.artikel') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Update Artikel</button>
            </div>
        </form>
    </div>
</div>
@endsection
