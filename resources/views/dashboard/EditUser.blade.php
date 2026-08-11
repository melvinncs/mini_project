@extends('dashboard.layout')

@section('title', 'Edit Akun')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Akun</h3>
    </div>
    <div class="card-body">
        @php
            $pengguna = session('pengguna');
            $isSelf = $pengguna && $user->id === (is_array($pengguna) ? $pengguna['id'] : $pengguna->id);
        @endphp

        @if($isSelf)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Anda sedang mengedit akun sendiri. Role tidak dapat diubah.
            </div>
        @endif

        <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                @error('nama')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" class="form-control" {{ $isSelf ? 'disabled' : '' }} required>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if($isSelf)
                    <input type="hidden" name="role" value="{{ $user->role }}">
                @endif
                @error('role')
                    <span class="error-text">{{ $message }}</span>
                @enderror
                @if($isSelf)
                    <small class="text-muted">Role tidak dapat diubah untuk akun sendiri</small>
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard.users.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">{{ $isSelf ? 'Update Akun Saya' : 'Update User' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection