<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Artikel;
use App\Models\Drama;

class DashboardController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();
        
        if (!session()->has('pengguna')) {
            session(['pengguna' => $pengguna]);
        }

        if ($pengguna->role === 'admin') {

            $totalArtikel = Artikel::count();
            $totalUsers = Pengguna::count();
            $totalAdmins = Pengguna::where('role', 'admin')->count();
            $totalUsersRole = Pengguna::where('role', 'user')->count();

            $artikels = Artikel::with('pengguna')
                ->latest()
                ->paginate(5);

            $users = Pengguna::where('role', 'user')->get();
            $admins = Pengguna::where('role', 'admin')->get();

            $dramas = Drama::with('pengguna')
                ->latest('diterbitkan_pada')
                ->paginate(10);

        } else {

            $totalArtikel = Artikel::where('id_pengguna', $pengguna->id)->count();

            $artikels = Artikel::where('id_pengguna', $pengguna->id)
                ->with('pengguna')
                ->latest()
                ->paginate(5);

            $totalUsers = null;
            $totalAdmins = null;
            $totalUsersRole = null;
            $users = collect();
            $admins = collect();

            $dramas = collect();
        }

        return view('dashboard.index', compact(
            'pengguna',
            'totalArtikel',
            'totalUsers',
            'totalAdmins',
            'totalUsersRole',
            'artikels',
            'users',
            'admins',
            'dramas'
        ));
    }

    public function manageUsers()
    {
        $users = Pengguna::all();
        $pengguna = Pengguna::find(session('pengguna_id'));

        return view('dashboard.user', compact('users', 'pengguna'));
    }

    public function changeRole(Request $request, $id)
    {
        $user = Pengguna::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Role user berhasil diubah!');
    }

    public function deleteUser($id)
    {
        $pengguna = Pengguna::find(session('pengguna_id'));
        $user = Pengguna::findOrFail($id);

        if ($user->id == $pengguna->id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }
}