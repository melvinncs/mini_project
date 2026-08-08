<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Cari pengguna berdasarkan email
        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna) {
            return back()->with('error', 'Email tidak terdaftar!');
        }

        // Verifikasi password
        if (!Hash::check($request->password, $pengguna->password)) {
            return back()->with('error', 'Password salah!');
        }

        // Login manual menggunakan session
        session(['pengguna' => $pengguna]);
        session(['pengguna_id' => $pengguna->id]);

        return redirect()->route('home')->with('success', 'Selamat datang kembali, ' . $pengguna->nama . '!');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:8|confirmed',
            'terms' => 'required',
        ]);

        // Buat pengguna baru
        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Auto login setelah register
        session(['pengguna' => $pengguna]);
        session(['pengguna_id' => $pengguna->id]);

        return redirect()->route('home')->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $pengguna->nama . '!');
    }

    // Proses logout
    public function logout(Request $request)
    {
        session()->forget(['pengguna', 'pengguna_id']);
        return redirect()->route('home')->with('success', 'Anda telah logout.');
    }
}