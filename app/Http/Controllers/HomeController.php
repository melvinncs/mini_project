<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Drama;

class HomeController extends Controller
{
    public function index()
    {
        $artikels = Artikel::with('pengguna')
            ->whereNotNull('diterbitkan_pada')
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();

        $dramas = Drama::with('pengguna')
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();

        return view('home', compact('artikels', 'dramas'));
    }
}