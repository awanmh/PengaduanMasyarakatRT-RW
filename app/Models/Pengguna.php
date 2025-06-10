<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Penting untuk otentikasi
use Illuminate\Notifications\Notifiable; // Untuk notifikasi

class Pengguna extends Authenticatable // Model ini digunakan untuk otentikasi (login)
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default Laravel akan menganggap 'penggunas',
     * jadi kita eksplisitkan menjadi 'pengguna'.
     *
     * @var string
     */
    protected $table = 'pengguna';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini penting untuk keamanan, mencegah mass assignment vulnerability.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     * Misalnya saat mengkonversi model ke array/JSON.
     * Password tidak boleh ditampilkan.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Jika Anda menggunakan fitur "remember me"
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * Ini bisa berguna jika Anda ingin otomatis mengkonversi tipe data kolom.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Jika Anda memiliki verifikasi email
        'password' => 'hashed', // Laravel 10+ otomatis hash password
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Model
    |--------------------------------------------------------------------------
    |
    | Definisikan relasi antar model sesuai dengan ERD.
    |
    */

    /**
     * Dapatkan semua pengaduan yang dibuat oleh pengguna ini.
     * Relasi One-to-Many: Satu Pengguna memiliki banyak Pengaduan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengaduans()
    {
        // 'user_id' adalah foreign key di tabel 'pengaduan' yang merujuk ke 'id' di tabel 'pengguna'
        return $this->hasMany(Pengaduan::class, 'user_id');
    }

    /**
     * Dapatkan semua komentar yang dibuat oleh pengguna ini.
     * Relasi One-to-Many: Satu Pengguna memiliki banyak Komentar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function komentars()
    {
        // 'user_id' adalah foreign key di tabel 'komentar' yang merujuk ke 'id' di tabel 'pengguna'
        return $this->hasMany(Komentar::class, 'user_id');
    }
}