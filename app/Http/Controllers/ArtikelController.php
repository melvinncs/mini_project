<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Pengguna;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::find(session('pengguna_id'));
        
        if (!$pengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        if ($pengguna->role === 'admin') {
            $artikels = Artikel::with('pengguna')->latest()->paginate(10);
        } else {
            $artikels = Artikel::where('id_pengguna', $pengguna->id)->with('pengguna')->latest()->paginate(10);
        }

        // Kirim $pengguna ke view
        return view('dashboard.artikel', [
            'artikels' => $artikels,
            'pengguna' => $pengguna
        ]);
    }

    public function create()
    {
        $pengguna = Pengguna::find(session('pengguna_id'));
        
        if (!$pengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('dashboard.TambahArtikel', ['pengguna' => $pengguna]);
    }

    public function store(Request $request)
    {
        $pengguna = Pengguna::find(session('pengguna_id'));

        if (!$pengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

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

        return redirect()
            ->route('dashboard.artikel')
            ->with('success', 'Artikel berhasil dipublikasikan.');
    }

    public function edit($id)
    {
        $pengguna = Pengguna::find(session('pengguna_id'));
        
        if (!$pengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $artikel = Artikel::findOrFail($id);
        
        if ($pengguna->role !== 'admin' && $artikel->id_pengguna !== $pengguna->id) {
            return redirect()->route('dashboard.artikel')->with('error', 'Anda tidak memiliki akses untuk mengedit artikel ini!');
        }

        return view('dashboard.EditArtikel', [
            'artikel' => $artikel,
            'pengguna' => $pengguna
        ]);
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::find(session('pengguna_id'));
        
        if (!$pengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $artikel = Artikel::findOrFail($id);
        
        if ($pengguna->role !== 'admin' && $artikel->id_pengguna !== $pengguna->id) {
            return redirect()->route('dashboard.artikel')->with('error', 'Anda tidak memiliki akses untuk mengedit artikel ini!');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
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
        $artikel->isi = $request->isi;
        $artikel->save();

        return redirect()->route('dashboard.artikel')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::find(session('pengguna_id'));
        
        if (!$pengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $artikel = Artikel::findOrFail($id);
        
        if ($pengguna->role !== 'admin' && $artikel->id_pengguna !== $pengguna->id) {
            return redirect()->route('dashboard.artikel')->with('error', 'Anda tidak memiliki akses untuk menghapus artikel ini!');
        }

        if ($artikel->thumbnail && file_exists(public_path($artikel->thumbnail))) {
            unlink(public_path($artikel->thumbnail));
        }

        $artikel->delete();

        return redirect()->route('dashboard.artikel')->with('success', 'Artikel berhasil dihapus!');
    }

    public function show($slug)
    {
        $pengguna = Pengguna::find(session('pengguna_id'));

        if (!$pengguna) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $artikel = Artikel::with('pengguna')->where('slug', $slug)->firstOrFail();

        if ($pengguna->role !== 'admin' && $artikel->id_pengguna !== $pengguna->id) {
            return redirect()->route('dashboard.artikel')->with('error', 'Anda tidak memiliki akses untuk melihat artikel ini!');
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
        
        return view('DetailArtikel', compact('artikel', 'artikels'));
    }
}