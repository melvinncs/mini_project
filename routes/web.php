<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DramaController;
use App\Http\Controllers\LandingPageController;

// Public Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/drama', [DramaController::class, 'publicIndex'])->name('drama');
Route::get('/drama/{slug}', [DramaController::class, 'showPublic'])->name('drama.detail');
Route::get('/artikel', [ArtikelController::class, 'publicIndex'])->name('artikel');
Route::get('/artikel/{slug}', [ArtikelController::class, 'showPublic'])->name('artikel.detail');

// Auth Route
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit'); 
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.delete');
    Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.show');

    // Drama
    Route::get('/drama', [DramaController::class, 'index'])->name('drama');
    Route::get('/drama/create', [DramaController::class, 'create'])->name('drama.create');
    Route::post('/drama', [DramaController::class, 'store'])->name('drama.store');
    Route::get('/drama/cari', [DramaController::class, 'cariDrama'])->name('drama.cari'); 
    Route::get('/drama/tmdb/{id}', [DramaController::class, 'detailDrama'])->name('drama.detailTmdb');
    Route::get('/drama/{id}/edit', [DramaController::class, 'edit'])->name('drama.edit');
    Route::put('/drama/{id}', [DramaController::class, 'update'])->name('drama.update');
    Route::delete('/drama/{id}', [DramaController::class, 'destroy'])->name('drama.delete');
    Route::get('/drama/{slug}', [DramaController::class, 'show'])->name('drama.show');

    // Landing Page
    Route::get('/landing-page', [LandingPageController::class, 'edit'])->name('landing-page');
    Route::put('/landing-page', [LandingPageController::class, 'update'])->name('landing-page.update');

    // Manajemen User
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::post('/{id}/role', [UserController::class, 'role'])->name('role');
        Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
    });
});

Route::middleware(['auth', 'role:user'])
->prefix('user')
->name('user.')
->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Artikel (user hanya kelola miliknya sendiri, kontrol kepemilikan tetap di controller)
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.show');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.delete');
});
