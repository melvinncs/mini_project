@extends('dashboard.layout')

@section('title', 'Edit Landing Page')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Landing Page</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.landing-page.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h4 style="margin-bottom:16px;">Hero Section</h4>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="hero_badge_1">Badge 1</label>
                    <input type="text" id="hero_badge_1" name="hero_badge_1" class="form-control" value="{{ old('hero_badge_1', $landing->hero_badge_1) }}">
                </div>
                <div class="form-group">
                    <label for="hero_badge_2">Badge 2</label>
                    <input type="text" id="hero_badge_2" name="hero_badge_2" class="form-control" value="{{ old('hero_badge_2', $landing->hero_badge_2) }}">
                </div>
                <div class="form-group">
                    <label for="hero_badge_3">Badge 3</label>
                    <input type="text" id="hero_badge_3" name="hero_badge_3" class="form-control" value="{{ old('hero_badge_3', $landing->hero_badge_3) }}">
                </div>
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="hero_title_line1">Judul Baris 1</label>
                    <input type="text" id="hero_title_line1" name="hero_title_line1" class="form-control" value="{{ old('hero_title_line1', $landing->hero_title_line1) }}">
                </div>
                <div class="form-group">
                    <label for="hero_title_highlight">Judul Highlight (warna gradient)</label>
                    <input type="text" id="hero_title_highlight" name="hero_title_highlight" class="form-control" value="{{ old('hero_title_highlight', $landing->hero_title_highlight) }}">
                </div>
                <div class="form-group">
                    <label for="hero_title_line2">Judul Baris 2</label>
                    <input type="text" id="hero_title_line2" name="hero_title_line2" class="form-control" value="{{ old('hero_title_line2', $landing->hero_title_line2) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="hero_description">Deskripsi Hero</label>
                <textarea id="hero_description" name="hero_description" class="form-control" rows="4">{{ old('hero_description', $landing->hero_description) }}</textarea>
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="hero_btn_primary_text">Teks Tombol Utama</label>
                    <input type="text" id="hero_btn_primary_text" name="hero_btn_primary_text" class="form-control" value="{{ old('hero_btn_primary_text', $landing->hero_btn_primary_text) }}">
                </div>
                <div class="form-group">
                    <label for="hero_btn_secondary_text">Teks Tombol Kedua</label>
                    <input type="text" id="hero_btn_secondary_text" name="hero_btn_secondary_text" class="form-control" value="{{ old('hero_btn_secondary_text', $landing->hero_btn_secondary_text) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="hero_image">Gambar Hero</label>
                @if($landing->hero_image)
                    <div class="current-thumbnail">
                        <img src="{{ asset($landing->hero_image) }}" alt="Hero Image" style="width: 160px; border-radius: 8px;">
                        <p class="text-muted">Gambar saat ini</p>
                    </div>
                @endif
                <input type="file" id="hero_image" name="hero_image" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar (Max 2MB)</small>
                @error('hero_image')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <hr style="margin: 32px 0; border-color: var(--border);">

            <h4 style="margin-bottom:16px;">Section Drama</h4>
            <div class="form-group">
                <label for="drama_tag">Tag</label>
                <input type="text" id="drama_tag" name="drama_tag" class="form-control" value="{{ old('drama_tag', $landing->drama_tag) }}">
            </div>
            <div class="form-group">
                <label for="drama_title">Judul Section</label>
                <input type="text" id="drama_title" name="drama_title" class="form-control" value="{{ old('drama_title', $landing->drama_title) }}">
            </div>
            <div class="form-group">
                <label for="drama_desc">Deskripsi</label>
                <textarea id="drama_desc" name="drama_desc" class="form-control" rows="2">{{ old('drama_desc', $landing->drama_desc) }}</textarea>
            </div>

            <hr style="margin: 32px 0; border-color: var(--border);">

            <h4 style="margin-bottom:16px;">Section Artikel</h4>
            <div class="form-group">
                <label for="artikel_tag">Tag</label>
                <input type="text" id="artikel_tag" name="artikel_tag" class="form-control" value="{{ old('artikel_tag', $landing->artikel_tag) }}">
            </div>
            <div class="form-group">
                <label for="artikel_title">Judul Section</label>
                <input type="text" id="artikel_title" name="artikel_title" class="form-control" value="{{ old('artikel_title', $landing->artikel_title) }}">
            </div>
            <div class="form-group">
                <label for="artikel_desc">Deskripsi</label>
                <textarea id="artikel_desc" name="artikel_desc" class="form-control" rows="2">{{ old('artikel_desc', $landing->artikel_desc) }}</textarea>
            </div>

            <hr style="margin: 32px 0; border-color: var(--border);">

            <h4 style="margin-bottom:16px;">Footer</h4>
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="footer_brand_short">Inisial Logo (contoh: KD)</label>
                    <input type="text" id="footer_brand_short" name="footer_brand_short" class="form-control" value="{{ old('footer_brand_short', $landing->footer_brand_short) }}">
                </div>
                <div class="form-group">
                    <label for="footer_brand_name">Nama Brand</label>
                    <input type="text" id="footer_brand_name" name="footer_brand_name" class="form-control" value="{{ old('footer_brand_name', $landing->footer_brand_name) }}">
                </div>
            </div>
            <div class="form-group">
                <label for="footer_description">Deskripsi Footer</label>
                <textarea id="footer_description" name="footer_description" class="form-control" rows="3">{{ old('footer_description', $landing->footer_description) }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection