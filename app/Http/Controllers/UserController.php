<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $pengguna = session('pengguna');

        if (!$pengguna) {
            abort(redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.'));
        }

        $role = is_array($pengguna) ? ($pengguna['role'] ?? null) : $pengguna->role;

        if ($role !== 'admin') {
            abort(redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke fitur ini.'));
        }
    }

    public function index()
    {
        $users = Pengguna::all();
        return view('dashboard.user', compact('users'));
    }

    public function create()
    {
        return view('dashboard.TambahUser');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = Pengguna::findOrFail($id);
        // $pengguna = session('pengguna');

        // $penggunaId = is_array($pengguna) ? $pengguna['id'] : ($pengguna->id ?? null);
        // if ($user->id === $penggunaId) {
        //     return redirect()->route('dashboard.users.index')
        //         ->with('error', 'Anda tidak dapat mengedit akun sendiri!');
        // }

        return view('dashboard.EditUser', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Pengguna::findOrFail($id);
        // $pengguna = session('pengguna');

        // $penggunaId = is_array($pengguna) ? $pengguna['id'] : ($pengguna->id ?? null);
        // if ($user->id === $penggunaId) {
        //     return redirect()->route('dashboard.users.index')
        //         ->with('error', 'Anda tidak dapat mengedit akun sendiri!');
        // }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function role(Request $request, $id)
    {
        $user = Pengguna::findOrFail($id);
        $pengguna = session('pengguna');

        $penggunaId = is_array($pengguna) ? $pengguna['id'] : ($pengguna->id ?? null);
        if ($user->id === $penggunaId) {
            return redirect()->route('dashboard.users.index')
                ->with('error', 'Anda tidak dapat mengubah role sendiri!');
        }

        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'Role user berhasil diubah!');
    }

    public function delete($id)
    {
        $user = Pengguna::findOrFail($id);
        $pengguna = session('pengguna');

        $penggunaId = is_array($pengguna) ? $pengguna['id'] : ($pengguna->id ?? null);
        if ($user->id === $penggunaId) {
            return redirect()->route('dashboard.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}