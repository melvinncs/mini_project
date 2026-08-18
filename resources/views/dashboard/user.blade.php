@extends('dashboard.layout')

@section('title', 'Manajemen Akun')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Pengguna</h3>
        <div class="card-header-actions">
            {{-- Ganti dashboard.users.create menjadi admin.users.create --}}
            <a href="{{ route('admin.users.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Akun
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge-role {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @php
                                $pengguna = session('pengguna');
                                $isSelf = $pengguna && $user->id === (is_array($pengguna) ? $pengguna['id'] : $pengguna->id);
                            @endphp
                            
                            {{-- Ganti dashboard.users.edit menjadi admin.users.edit --}}
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            @if(!$isSelf)
                                {{-- Ganti dashboard.users.delete menjadi admin.users.delete --}}
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted" style="margin-left: 5px;">(Akun sendiri)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection