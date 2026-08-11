<?php

use Illuminate\Support\Facades\Route;
use App\Models\Artikel;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DramaController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/drama', [DramaController::class, 'publicIndex'])->name('drama');
Route::get('/artikel', [ArtikelController::class, 'publicIndex'])->name('artikel');

// Route::get('/', function () {
//     return view('home');
// })->name('home');

// Route::get('/drama', function () {
//     return view('drama');
// })->name('drama');

Route::get('/artikel', function () {
    $artikels = Artikel::with('pengguna')->latest()->paginate(10);
    return view('artikel', compact('artikels'));
})->name('artikel');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Dashboard Routes
Route::prefix('dashboard')->group(function () {
    // dashboard artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('dashboard.artikel');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('dashboard.artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('dashboard.artikel.store');
    Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('dashboard.artikel.show');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('dashboard.artikel.edit');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('dashboard.artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('dashboard.artikel.delete');

    // dashboard drama (admin)
    Route::get('/drama', [DramaController::class, 'index'])->name('dashboard.drama');
    Route::get('/drama/create', [DramaController::class, 'create'])->name('dashboard.drama.create');
    Route::post('/drama', [DramaController::class, 'store'])->name('dashboard.drama.store');

    // pencarian TMDB 
    Route::get('/drama/cari', [DramaController::class, 'cariDrama'])->name('dashboard.drama.cari');
    Route::get('/drama/tmdb/{id}', [DramaController::class, 'detailDrama'])->name('dashboard.drama.detailTmdb');

    Route::get('/drama/{slug}', [DramaController::class, 'show'])->name('dashboard.drama.show');
    Route::get('/drama/{id}/edit', [DramaController::class, 'edit'])->name('dashboard.drama.edit');
    Route::put('/drama/{id}', [DramaController::class, 'update'])->name('dashboard.drama.update');
    Route::delete('/drama/{id}', [DramaController::class, 'destroy'])->name('dashboard.drama.delete');
});
// Route::get('/dashboard/users', [DashboardController::class, 'manageUsers'])->name('dashboard.users');
// Route::post('/dashboard/users/{id}/role', [DashboardController::class, 'changeRole'])->name('dashboard.users.role');
// Route::delete('/dashboard/users/{id}', [DashboardController::class, 'deleteUser'])->name('dashboard.users.delete');

// Artikel Routes
// Route::get('/artikel', [ArtikelController::class, 'publicIndex'])->name('artikel');
// Route::get('/artikel/{slug}', [ArtikelController::class, 'showPublic'])->name('artikel.detail');
// Route::get('/dashboard/artikel', [ArtikelController::class, 'index'])->name('dashboard.artikel');
// Route::get('/dashboard/artikel/create', [ArtikelController::class, 'create'])->name('dashboard.artikel.create');
// Route::post('/dashboard/artikel', [ArtikelController::class, 'store'])->name('dashboard.artikel.store');
// Route::get('/dashboard/artikel/{slug}', [ArtikelController::class, 'show'])->name('dashboard.artikel.show');
// Route::get('/dashboard/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('dashboard.artikel.edit');
// Route::put('/dashboard/artikel/{id}', [ArtikelController::class, 'update'])->name('dashboard.artikel.update');
// Route::delete('/dashboard/artikel/{id}', [ArtikelController::class, 'destroy'])->name('dashboard.artikel.delete');

Route::prefix('dashboard/users')->name('dashboard.users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::post('/{id}/role', [UserController::class, 'role'])->name('role');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
});

Route::get('/artikel/{slug}', [ArtikelController::class, 'showPublic'])->name('artikel.detail');
Route::get('/drama/{slug}', [DramaController::class, 'showPublic'])->name('drama.detail');