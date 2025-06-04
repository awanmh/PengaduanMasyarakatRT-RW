<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\CommentController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('kategoris', KategoriController::class);
    Route::resource('pengaduan', PengaduanController::class)->except(['edit', 'update']);

    // Komentar pengaduan
    Route::post('/pengaduan/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/pengaduan/{id}/comments/{comment_id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Role RT
Route::middleware(['auth', 'role:rt'])->group(function () {
    Route::get('/rt/pengaduan', [PengaduanController::class, 'adminIndex'])->name('rt.pengaduan.index');
    Route::patch('/rt/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('rt.pengaduan.status');
});

// Auth
require __DIR__.'/auth.php';
