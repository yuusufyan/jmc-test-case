<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KategoriController;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin', // ⬅️ tambahin begini
])->group(function () {
    Route::resource('users', UserController::class);
});

// Kategori Router
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin',
])->group(function () {
    Route::resource('kategori', KategoriController::class)->except('show');
});

// Sub - Kategori Router
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin',
])->group(function () {
    Route::resource('sub-kategori', SubKategoriController::class)->except('show');
    Route::get('/get-subkategori/{kategori_id}', [SubKategoriController::class, 'getSubKategori']);
});
// Route::get('/kategori/datatable', [KategoriController::class, 'datatable'])->name('kategori.datatable');

// Transaksi Router
Route::middleware([
    'auth',
    // RoleMiddleware::class . ':admin',
])->group(function () {
    Route::resource('transaksi', TransaksiController::class)->except('show');
});

require __DIR__ . '/auth.php';
