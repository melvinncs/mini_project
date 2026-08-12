<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Drama;
use App\Models\LandingPage;

class HomeController extends Controller
{
    public function index()
    {
        $genreAliases = [
            'Aksi & Petualangan' => ['Aksi & Petualangan', 'Action & Adventure', 'Action', 'Adventure'],
            'Animasi' => ['Animasi', 'Animation'],
            'Komedi' => ['Komedi', 'Comedy'],
            'Kejahatan' => ['Kejahatan', 'Crime'],
            'Drama' => ['Drama'],
            'Misteri' => ['Misteri', 'Mystery'],
            'Romantis' => ['Romantis', 'Romance'],
        ];

        $artikels = Artikel::with('pengguna')
            ->whereNotNull('diterbitkan_pada')
            ->when(request('artikel_cari'), function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('judul', 'like', "%{$keyword}%")
                        ->orWhere('isi', 'like', "%{$keyword}%");
                });
            })
            ->when(request('artikel_kategori'), fn ($query, $kategori) => $query->where('kategori', $kategori))
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();

        $dramas = Drama::with('pengguna')
            ->when(request('drama_cari'), function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('judul', 'like', "%{$keyword}%")
                        ->orWhere('sinopsis', 'like', "%{$keyword}%");
                });
            })
            ->when(request('drama_genre'), function ($query, $genre) use ($genreAliases) {
                $query->where(function ($query) use ($genre, $genreAliases) {
                    foreach ($genreAliases[$genre] ?? [$genre] as $alias) {
                        $query->orWhere('genre', 'like', "%{$alias}%");
                    }
                });
            })
            ->when(request('drama_tahun'), fn ($query, $tahun) => $query->where('tahun', $tahun))
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();

        $landing = LandingPage::current();

        return view('home', compact('artikels', 'dramas', 'landing'));
    }
}
