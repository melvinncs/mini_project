<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Pengguna;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();

        if ($pengguna->role === 'admin') {
            $artikels = Artikel::with('pengguna')->latest()->paginate(10);
        } else {
            $artikels = Artikel::where('id_pengguna', $pengguna->id)->with('pengguna')->latest()->paginate(10);
        }

        return view('dashboard.artikel', [
            'artikels' => $artikels,
            'pengguna' => $pengguna
        ]);
    }

    public function create()
    {
        $pengguna = Auth::user();
        // Ubah dari user.TambahArtikel menjadi dashboard.TambahArtikel
        return view('dashboard.TambahArtikel', ['pengguna' => $pengguna]);
    }

    public function store(Request $request)
    {
        $pengguna = Auth::user();

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isi' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/thumbnails'), $filename);
            $thumbnail = 'uploads/thumbnails/' . $filename;
        }

        Artikel::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'kategori' => $request->kategori,
            'isi' => $request->isi,
            'thumbnail' => $thumbnail,
            'id_pengguna' => $pengguna->id,
            'diterbitkan_pada' => now(),
        ]);

        // Tentukan route berdasarkan role
        $route = $pengguna->role === 'admin' ? 'admin.artikel' : 'user.artikel';
        return redirect()->route($route)->with('success', 'Artikel berhasil dipublikasikan.');
    }

    public function edit($id)
    {
        $pengguna = Auth::user();
        $artikel = Artikel::findOrFail($id);

        if ($pengguna->role !== 'admin' && $artikel->id_pengguna !== $pengguna->id) {
            $route = $pengguna->role === 'admin' ? 'admin.artikel' : 'user.artikel';
            return redirect()->route($route)->with('error', 'Anda tidak memiliki akses untuk mengedit artikel ini!');
        }

        // Ubah dari user.EditArtikel menjadi dashboard.EditArtikel
        return view('dashboard.EditArtikel', [
            'artikel' => $artikel,
            'pengguna' => $pengguna
        ]);
    }

    public function update(Request $request, $id)
    {
        $pengguna = Auth::user();
        $artikel = Artikel::findOrFail($id);

        if ($pengguna->role !== 'admin' && $artikel->id_pengguna !== $pengguna->id) {
            $route = $pengguna->role === 'admin' ? 'admin.artikel' : 'user.artikel';
            return redirect()->route($route)->with('error', 'Anda tidak memiliki akses untuk mengedit artikel ini!');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->judul !== $artikel->judul) {
            $slug = Str::slug($request->judul);
            $originalSlug = $slug;
            $counter = 1;

            while (Artikel::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $artikel->slug = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            if ($artikel->thumbnail && file_exists(public_path($artikel->thumbnail))) {
                unlink(public_path($artikel->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/thumbnails'), $filename);
            $artikel->thumbnail = 'uploads/thumbnails/' . $filename;
        }

        $artikel->judul = $request->judul;
        $artikel->kategori = $request->kategori;
        $artikel->isi = $request->isi;
        $artikel->save();

        $route = $pengguna->role === 'admin' ? 'admin.artikel' : 'user.artikel';
        return redirect()->route($route)->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengguna = Auth::user();
        $artikel = Artikel::findOrFail($id);

        if ($pengguna->role !== 'admin' && $artikel->id_pengguna !== $pengguna->id) {
            $route = $pengguna->role === 'admin' ? 'admin.artikel' : 'user.artikel';
            return redirect()->route($route)->with('error', 'Anda tidak memiliki akses untuk menghapus artikel ini!');
        }

        if ($artikel->thumbnail && file_exists(public_path($artikel->thumbnail))) {
            unlink(public_path($artikel->thumbnail));
        }

        $artikel->delete();

        $route = $pengguna->role === 'admin' ? 'admin.artikel' : 'user.artikel';
        return redirect()->route($route)->with('success', 'Artikel berhasil dihapus!');
    }

    public function show($slug)
    {
        $pengguna = Auth::user();
        $artikel = Artikel::with('pengguna')->where('slug', $slug)->firstOrFail();

        if ($pengguna->role !== 'admin' && $artikel->id_pengguna !== $pengguna->id) {
            $route = $pengguna->role === 'admin' ? 'admin.artikel' : 'user.artikel';
            return redirect()->route($route)->with('error', 'Anda tidak memiliki akses untuk melihat artikel ini!');
        }

        return view('dashboard.DetailArtikel', [
            'artikel' => $artikel,
            'pengguna' => $pengguna
        ]);
    }

    public function showPublic($slug)
    {
        $artikel = Artikel::with('pengguna')->where('slug', $slug)->firstOrFail();
        $artikels = Artikel::with('pengguna')->latest()->take(3)->get();

        return view('dashboard.DetailArtikel', compact('artikel', 'artikels'));
    }

    public function publicIndex()
    {
        $artikels = Artikel::with('pengguna')
            ->latest('diterbitkan_pada')
            ->paginate(12)
            ->withQueryString();

        return view('artikel', compact('artikels'));
    }
}