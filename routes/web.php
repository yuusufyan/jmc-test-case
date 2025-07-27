<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubKategoriController;
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

// Items Router
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin',
])->group(function () {
    Route::resource('kategori', KategoriController::class)->except('show');
});

Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin',
])->group(function () {
    Route::resource('sub-kategori', SubKategoriController::class)->except('show');
});
// Route::get('/kategori/datatable', [KategoriController::class, 'datatable'])->name('kategori.datatable');


require __DIR__ . '/auth.php';
