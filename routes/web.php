<?php

// Pastikan import semua Controller yang akan digunakan ada di bagian paling atas
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomentarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk cek autentikasi

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute Publik Utama - Arahkan ke Login jika belum autentikasi, ke Dashboard jika sudah.
Route::get('/', function () {
    if (Auth::check()) {
        // Jika pengguna sudah login, arahkan ke dashboard utama
        return redirect()->route('dashboard');
    }
    // Jika pengguna belum login, arahkan ke halaman login
    return redirect()->route('login');
});

// Ini adalah rute-rute otentikasi dari Laravel Breeze (login, register, reset password, dll.)
// Laravel Breeze akan otomatis mengarahkan ke RouteServiceProvider::HOME setelah login.
require __DIR__.'/auth.php';

// Rute Terlindungi (Memerlukan pengguna untuk login dan email terverifikasi)
// Middleware 'auth' dan 'verified' tetap sangat penting di sini untuk semua rute di dalam grup ini.
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Dashboard Umum (Ini adalah rute "/dashboard" yang akan diakses setelah login) ---
    // Rute ini berfungsi sebagai gerbang untuk mengarahkan pengguna ke dashboard yang sesuai dengan peran mereka.
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'RT') {
            return redirect()->route('rt.dashboard');
        }
        return redirect()->route('warga.dashboard');
    })->name('dashboard');

    // --- Rute Profil (dari Laravel Breeze) ---
    // Rute untuk mengelola profil pengguna (edit, update, delete akun)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- Rute RESOURCE PENGADUAN (CRUD: index, create, store, show, edit, update, destroy) ---
    // Rute ini akan mendaftarkan semua aksi CRUD standar untuk model Pengaduan.
    // Otoriisasi berdasarkan peran (RT/Warga) akan ditangani DI DALAM PengaduanController.
    Route::resource('pengaduan', PengaduanController::class);


    // --- Rute untuk Menambah Komentar pada Pengaduan ---
    // Ini adalah rute POST untuk menyimpan komentar baru ke sebuah pengaduan.
    // Otoriisasi akan ditangani di dalam KomentarController.
    Route::post('/pengaduan/{pengaduan}/komentar', [KomentarController::class, 'store'])->name('pengaduan.komentar.store');


    // --- Rute RESOURCE KATEGORI (CRUD) ---
    // Otoriisasi akan ditangani di dalam KategoriController (biasanya hanya RT/Admin yang boleh mengelola).
    Route::resource('kategori', KategoriController::class);


    /*
    |--------------------------------------------------------------------------
    | Rute Spesifik Peran (Otorisasi DITANGANI DI CONTROLLER)
    |--------------------------------------------------------------------------
    |
    | Rute di bawah ini sekarang tidak lagi menggunakan middleware 'role' di definisi rute ini.
    | Sebagai gantinya, masing-masing metode di Controller (contoh: dashboardRT, dashboardWarga)
    | memiliki logika pengecekan peran di awal metode.
    |
    */

    // --- Rute Dashboard dan Aksi Khusus untuk Peran 'RT' ---
    Route::get('/dashboard-rt', [PengaduanController::class, 'dashboardRT'])->name('rt.dashboard');
    Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');


    // --- Rute Dashboard dan Aksi Khusus untuk Peran 'Warga' ---
    Route::get('/dashboard-warga', [PengaduanController::class, 'dashboardWarga'])->name('warga.dashboard');
    Route::get('/my-pengaduans', [PengaduanController::class, 'myPengaduans'])->name('warga.my_pengaduans');
});
