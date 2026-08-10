@extends('dashboard.layout')

@section('title', 'Edit Drama')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Drama</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.drama.update', $drama->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="judul">Judul Drama</label>
                <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul', $drama->judul) }}" required>
                @error('judul')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" class="form-control" placeholder="Contoh: Romance, Comedy, Thriller" value="{{ old('genre', $drama->genre) }}">
                @error('genre')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" id="tahun" name="tahun" class="form-control" value="{{ old('tahun', $drama->tahun) }}" min="1900" max="{{ date('Y') }}">
                    @error('tahun')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="episode">Jumlah Episode</label>
                    <input type="number" id="episode" name="episode" class="form-control" value="{{ old('episode', $drama->episode) }}" min="1">
                    @error('episode')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rating">Rating</label>
                    <input type="text" id="rating" name="rating" class="form-control" placeholder="8.5" value="{{ old('rating', $drama->rating) }}">
                    @error('rating')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="Ongoing" {{ old('status', $drama->status) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="Completed" {{ old('status', $drama->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Upcoming" {{ old('status', $drama->status) == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="On Hold" {{ old('status', $drama->status) == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                </select>
                @error('status')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pemeran_utama">Pemeran Utama</label>
                <input type="text" id="pemeran_utama" name="pemeran_utama" class="form-control" placeholder="Contoh: Kim Soo-hyun, Kim Ji-won" value="{{ old('pemeran_utama', $drama->pemeran_utama) }}">
                @error('pemeran_utama')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                @if($drama->thumbnail)
                <div class="current-thumbnail">
                    <img src="{{ asset($drama->thumbnail) }}" alt="Current Thumbnail" style="width: 120px; height: 160px; object-fit: cover; border-radius: 8px;">
                    <p class="text-muted">Thumbnail saat ini</p>
                </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti thumbnail (Max 2MB)</small>
                @error('thumbnail')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sinopsis">Sinopsis</label>
                <textarea id="sinopsis" name="sinopsis" class="form-control" rows="8">{{ old('sinopsis', $drama->sinopsis) }}</textarea>
                @error('sinopsis')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard.drama') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Update Drama</button>
            </div>
        </form>
    </div>
</div>
@endsection