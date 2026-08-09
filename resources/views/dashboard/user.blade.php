@extends('dashboard.layout')

@section('title', 'Manajemen User')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Pengguna</h3>
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
                            @if($pengguna && $user->id !== $pengguna->id)
                            <form action="{{ route('dashboard.users.role', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <select name="role" onchange="this.form.submit()" class="role-select">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                            <form action="{{ route('dashboard.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <span class="text-muted">Anda</span>
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