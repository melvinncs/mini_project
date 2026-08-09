@extends('dashboard.layout')

@section('title', 'Manajemen User')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Pengguna</h3>
        <div class="card-header-actions">
            <a href="{{ route('dashboard.users.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah User
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
                            @endphp
                            
                            @if($pengguna && $user->id !== (is_array($pengguna) ? $pengguna['id'] : $pengguna->id))
                                <!-- Edit User -->
                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Delete User -->
                                <form action="{{ route('dashboard.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Anda (Tidak dapat mengedit diri sendiri)</span>
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