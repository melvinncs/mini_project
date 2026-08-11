<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drama;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class DramaController extends Controller
{
    private function cekAksesAdmin()
    {
        $pengguna = session('pengguna');
        $role = is_array($pengguna) ? $pengguna['role'] ?? null : $pengguna->role ?? null;

        if ($role !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        return null; 
    }

    public function index()
    {
        if ($redirect = $this->cekAksesAdmin()) return $redirect;

        $dramas = Drama::with('pengguna')->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.drama', compact('dramas'));
    }

    public function create()
    {
        if ($redirect = $this->cekAksesAdmin()) return $redirect;

        return view('dashboard.TambahDrama');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->cekAksesAdmin()) return $redirect;

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'tahun' => 'nullable|integer|min:1900|max:' . date('Y'),
            'episode' => 'nullable|integer|min:1',
            'rating' => 'nullable|string|max:10',
            'status' => 'nullable|string|in:Ongoing,Completed,Upcoming,On Hold',
            'pemeran_utama' => 'nullable|string',
            'sinopsis' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate slug
        $slug = Str::slug($request->judul);
        $count = Drama::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        // Upload thumbnail
        $thumbnailPath = null;

        // PASTIKAN DIREKTORI ADA
        $uploadPath = public_path('uploads/drama');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/drama'), $filename);
            $thumbnailPath = 'uploads/drama/' . $filename;
    } elseif ($request->filled('tmdb_poster_url')) {
        $response = Http::timeout(10)->get($request->tmdb_poster_url);

        if ($response->successful() && str_starts_with($response->header('Content-Type'), 'image/')) {
            $filename = time() . '_tmdb.jpg';
            file_put_contents(public_path('uploads/drama/' . $filename), $response->body());
            $thumbnailPath = 'uploads/drama/' . $filename;
        }
    }

        // Ambil data pengguna dari session (admin yang login)
        $pengguna = session('pengguna');
        $idPengguna = is_array($pengguna) ? $pengguna['id'] : $pengguna->id;

        $drama = Drama::create([
            'id_pengguna' => $idPengguna,
            'judul' => $request->judul,
            'slug' => $slug,
            'thumbnail' => $thumbnailPath,
            'sinopsis' => $request->sinopsis,
            'genre' => $request->genre,
            'tahun' => $request->tahun,
            'episode' => $request->episode,
            'rating' => $request->rating,
            'status' => $request->status ?? 'Ongoing',
            'pemeran_utama' => $request->pemeran_utama,
            'diterbitkan_pada' => now()
        ]);

        return redirect()->route('dashboard.drama')
            ->with('success', 'Drama berhasil ditambahkan!');
    }

    // Menampilkan detail drama
    public function show($slug)
    {
        $drama = Drama::with('pengguna')->where('slug', $slug)->firstOrFail();
        return view('dashboard.DetailDrama', compact('drama'));
    }

    // Menampilkan form edit drama
    public function edit($id)
    {
        $drama = Drama::findOrFail($id);
        return view('dashboard.EditDrama', compact('drama'));
    }

    // Mengupdate drama
    public function update(Request $request, $id)
    {
        $drama = Drama::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'tahun' => 'nullable|integer|min:1900|max:' . date('Y'),
            'episode' => 'nullable|integer|min:1',
            'rating' => 'nullable|string|max:10',
            'status' => 'nullable|string|in:Ongoing,Completed,Upcoming,On Hold',
            'pemeran_utama' => 'nullable|string',
            'sinopsis' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // PASTIKAN DIREKTORI ADA
        $uploadPath = public_path('uploads/drama');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Upload thumbnail baru jika ada
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama
            if ($drama->thumbnail && file_exists(public_path($drama->thumbnail))) {
                unlink(public_path($drama->thumbnail));
            }
            
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/drama'), $filename);
            $drama->thumbnail = 'uploads/drama/' . $filename;
        }

        $drama->judul = $request->judul;
        $drama->sinopsis = $request->sinopsis;
        $drama->genre = $request->genre;
        $drama->tahun = $request->tahun;
        $drama->episode = $request->episode;
        $drama->rating = $request->rating;
        $drama->status = $request->status ?? $drama->status;
        $drama->pemeran_utama = $request->pemeran_utama;
        $drama->save();

        return redirect()->route('dashboard.drama')
            ->with('success', 'Drama berhasil diperbarui!');
    }

    // Menghapus drama
    public function destroy($id)
    {
        $drama = Drama::findOrFail($id);
        
        // Hapus thumbnail
        if ($drama->thumbnail && file_exists(public_path($drama->thumbnail))) {
            unlink(public_path($drama->thumbnail));
        }

        $drama->delete();

        return redirect()->route('dashboard.drama')
            ->with('success', 'Drama berhasil dihapus!');
    }

    // Mencari drama di TMDB berdasarkan judul
    public function cariDrama(Request $request)
    {
        $query = $request->get('query');

        if (!$query) {
            return response()->json([]);
        }

        $response = Http::withToken(config('services.tmdb.token'))
            ->acceptJson()
            ->get('https://api.themoviedb.org/3/search/tv', [
                'query' => $query,
                'language' => 'id-ID',
                'include_adult' => false,
            ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Gagal mengambil data dari TMDB'], 500);
        }

        $hasil = collect($response->json('results'))
            // filter supaya hanya drama dengan negara asal Korea Selatan yang muncul
            ->filter(fn ($item) => in_array('KR', $item['origin_country'] ?? []))
            ->map(fn ($item) => [
                'id' => $item['id'],
                'judul' => $item['name'],
                'tahun' => substr($item['first_air_date'] ?? '', 0, 4),
                'poster' => $item['poster_path']
                    ? "https://image.tmdb.org/t/p/w200{$item['poster_path']}"
                    : null,
            ])
            ->values();

        return response()->json($hasil);
    }

    // Mengambil detail lengkap drama yang dipilih
    public function detailDrama($id)
    {
        $response = Http::withToken(config('services.tmdb.token'))
            ->acceptJson()
            ->get("https://api.themoviedb.org/3/tv/{$id}", [
                'language' => 'id-ID',
                'append_to_response' => 'credits',
            ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Gagal mengambil detail drama'], 500);
        }

        $data = $response->json();

        $pemeran = collect($data['credits']['cast'] ?? [])
            ->take(5)
            ->pluck('name')
            ->implode(', ');

        return response()->json([
            'judul' => $data['name'],
            'genre' => collect($data['genres'] ?? [])->pluck('name')->implode(', '),
            'tahun' => substr($data['first_air_date'] ?? '', 0, 4),
            'episode' => $data['number_of_episodes'] ?? null,
            'rating' => $data['vote_average'] ? number_format($data['vote_average'], 1) : null,
            'sinopsis' => $data['overview'],
            'pemeran_utama' => $pemeran,
            'poster_url' => $data['poster_path']
                ? "https://image.tmdb.org/t/p/w500{$data['poster_path']}"
                : null,
        ]);
    }

    public function publicIndex()
    {
        $dramas = Drama::with('pengguna')
            ->latest('diterbitkan_pada')
            ->paginate(12)
            ->withQueryString();

        return view('drama', compact('dramas'));
    }

    public function showPublic($slug)
    {
        $drama = Drama::with('pengguna')->where('slug', $slug)->firstOrFail();
        $dramas = Drama::with('pengguna')->latest()->take(3)->get();
        
        return view('dashboard.DetailDrama', compact('drama', 'dramas'));
    }
}
