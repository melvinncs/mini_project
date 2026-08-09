<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna) {
            return back()->with('error', 'Email tidak terdaftar!');
        }

        if (!Hash::check($request->password, $pengguna->password)) {
            return back()->with('error', 'Password salah!');
        }

        // Simpan sebagai object
        session(['pengguna' => $pengguna]);
        session(['pengguna_id' => $pengguna->id]);

        return redirect()->route('dashboard')->with('success', 'Selamat datang kembali, ' . $pengguna->nama . '!');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:8|confirmed',
            'terms' => 'required',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login dengan akun Anda.');
    }

    public function logout(Request $request)
    {
        session()->forget(['pengguna', 'pengguna_id']);
        return redirect()->route('home')->with('success', 'Anda telah logout.');
    }
}