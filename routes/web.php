<?php

// Pastikan import semua Controller yang akan digunakan ada di bagian paling atas
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomentarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// --- Rute Publik ---
// Halaman selamat datang default, dapat diakses oleh siapa saja.
// Setelah pengguna login, mereka akan diarahkan ke '/dashboard' secara otomatis
// oleh konfigurasi Laravel Breeze di RouteServiceProvider.php.
Route::get('/', function () {
    return view('welcome');
});

// --- Rute Autentikasi ---
// Rute-rute ini disediakan oleh Laravel Breeze (login, register, reset password, dll.).
// Tidak perlu diubah, Breeze akan mengelola pengalihan dan keamanan.
require __DIR__.'/auth.php';


// --- Rute Terlindungi (Memerlukan Login dan Verifikasi Email) ---
// Semua rute di dalam grup ini hanya bisa diakses oleh pengguna yang sudah login
// dan telah memverifikasi alamat email mereka. Middleware 'auth' dan 'verified'
// akan secara otomatis mengarahkan pengguna yang tidak memenuhi syarat ke halaman yang tepat.
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Rute Dashboard Utama ---
    // Rute ini berfungsi sebagai gerbang untuk mengarahkan pengguna ke dashboard yang sesuai.
    // Logic pengecekan peran (role) ada di dalam function ini.
    Route::get('/dashboard', function () {
        // Pengecekan peran pengguna dan pengalihan ke rute dashboard yang spesifik.
        if (Auth::user()->role === 'RT') {
            return redirect()->route('rt.dashboard');
        }
        return redirect()->route('warga.dashboard');
    })->name('dashboard');

    // --- Rute Dashboard dan Aksi Khusus untuk Peran 'RT' ---
    Route::get('/dashboard-rt', [PengaduanController::class, 'dashboardRT'])->name('rt.dashboard');
    Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');


    // --- Rute Dashboard dan Aksi Khusus untuk Peran 'Warga' ---
    Route::get('/dashboard-warga', [PengaduanController::class, 'dashboardWarga'])->name('warga.dashboard');
    Route::get('/my-pengaduans', [PengaduanController::class, 'myPengaduans'])->name('warga.my_pengaduans');


    // --- Rute Manajemen Pengaduan ---
    // Menggunakan Route::resource untuk mendaftarkan semua rute CRUD standar.
    // Authorisasi (misal: hanya RT yang bisa update status) akan ditangani di dalam Controller.
    Route::resource('pengaduan', PengaduanController::class)->names([
        'index' => 'pengaduan.index',
        'create' => 'pengaduan.create',
        'store' => 'pengaduan.store',
        'show' => 'pengaduan.show',
        'edit' => 'pengaduan.edit',
        'update' => 'pengaduan.update',
        'destroy' => 'pengaduan.destroy',
    ]);


    // --- Rute Komentar ---
    // Rute POST untuk menyimpan komentar baru pada sebuah pengaduan.
    Route::post('/pengaduan/{pengaduan}/komentar', [KomentarController::class, 'store'])->name('pengaduan.komentar.store');


    // --- Rute Manajemen Kategori ---
    // Menggunakan Route::resource.
    // Authorisasi (hanya RT yang bisa mengelola) akan ditangani di dalam Controller.
    Route::resource('kategori', KategoriController::class)->names([
        'index' => 'kategori.index',
        'create' => 'kategori.create',
        'store' => 'kategori.store',
        'show' => 'kategori.show',
        'edit' => 'kategori.edit',
        'update' => 'kategori.update',
        'destroy' => 'kategori.destroy',
    ]);


    // --- Rute Profil (dari Laravel Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
