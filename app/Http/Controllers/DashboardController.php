<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Artikel;

class DashboardController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::find(session('pengguna_id'));

        if (!$pengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $totalArtikel = Artikel::count();
        $totalUsers = Pengguna::count();
        $artikels = Artikel::with('pengguna')->latest()->paginate(5);
        $users = Pengguna::where('role', 'user')->get();
        $admins = Pengguna::where('role', 'admin')->get();

        return view('dashboard.index', compact('pengguna', 'totalArtikel', 'totalUsers', 'artikels', 'users', 'admins'));
    }

    public function manageUsers()
    {
        $pengguna = Pengguna::find(session('pengguna_id'));

        if (!$pengguna || $pengguna->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $users = Pengguna::all();
        return view('dashboard.user', compact('users', 'pengguna'));
    }

    public function changeRole(Request $request, $id)
    {
        $pengguna = Pengguna::find(session('pengguna_id'));

        if (!$pengguna || $pengguna->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $user = Pengguna::findOrFail($id);
        
        if ($user->id == $pengguna->id) {
            return back()->with('error', 'Tidak dapat mengubah role sendiri!');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Role user berhasil diubah!');
    }

    public function deleteUser($id)
    {
        $pengguna = Pengguna::find(session('pengguna_id'));

        if (!$pengguna || $pengguna->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $user = Pengguna::findOrFail($id);
        
        if ($user->id == $pengguna->id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }
}