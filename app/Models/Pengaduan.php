<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default Laravel akan menganggap 'pengaduans',
     * jadi kita eksplisitkan menjadi 'pengaduan'.
     *
     * @var string
     */
    protected $table = 'pengaduan';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'isi',
        'lampiran',
        'status',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Contoh jika ada kolom tanggal/waktu spesifik yang ingin di-cast
        // 'tanggal_kejadian' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Model
    |--------------------------------------------------------------------------
    */

    /**
     * Dapatkan pengguna yang membuat pengaduan ini.
     * Relasi Many-to-One: Banyak Pengaduan dimiliki oleh satu Pengguna.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengguna()
    {
        // 'user_id' adalah foreign key di tabel 'pengaduan'
        // 'id' adalah primary key di tabel 'pengguna'
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    /**
     * Dapatkan kategori dari pengaduan ini.
     * Relasi Many-to-One: Banyak Pengaduan dimiliki oleh satu Kategori.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        // 'kategori_id' adalah foreign key di tabel 'pengaduan'
        // 'id' adalah primary key di tabel 'kategori'
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Dapatkan semua komentar untuk pengaduan ini.
     * Relasi One-to-Many: Satu Pengaduan memiliki banyak Komentar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function komentars()
    {
        // 'pengaduan_id' adalah foreign key di tabel 'komentar' yang merujuk ke 'id' di tabel 'pengaduan'
        return $this->hasMany(Komentar::class, 'pengaduan_id');
    }
}