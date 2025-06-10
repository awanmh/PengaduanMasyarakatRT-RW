# Aplikasi Pengaduan Masyarakat RT-RW

Aplikasi Pengaduan Masyarakat RT-RW adalah platform berbasis web yang dirancang untuk memfasilitasi komunikasi antara warga dan Ketua RT terkait pengaduan atau masalah yang terjadi di lingkungan mereka. Aplikasi ini memungkinkan warga untuk dengan mudah melaporkan masalah, melacak status pengaduan mereka, dan berkomunikasi melalui komentar, sementara Ketua RT dapat mengelola, memproses, dan menyelesaikan pengaduan.

## Fitur Utama

### Autentikasi Pengguna
- Registrasi dan Login untuk warga dan Ketua RT.
- Pemilihan peran (role: Warga / RT) saat registrasi (perlu hati-hati untuk produksi).

### Manajemen Pengaduan (Warga)
- Membuat pengaduan baru dengan judul, isi, kategori, dan lampiran (opsional).
- Melihat daftar pengaduan pribadi yang telah dibuat.
- Melihat detail pengaduan beserta status dan komentar.
- Mengedit atau menghapus pengaduan yang masih dalam status 'pending' (hanya milik sendiri).

### Manajemen Pengaduan (Ketua RT)
- Melihat dashboard ringkasan pengaduan (total, pending, proses, selesai).
- Melihat daftar semua pengaduan yang masuk.
- Melihat detail pengaduan, termasuk informasi pelapor.
- Memperbarui status pengaduan (pending / proses / selesai).
- Memberikan komentar pada pengaduan.
- Mengedit atau menghapus pengaduan.

### Manajemen Kategori (Ketua RT)
- Menambah, mengedit, dan menghapus kategori pengaduan (misalnya: "Jalan Rusak", "Sampah Menumpuk", "Keamanan").

### Sistem Komentar
- Pengguna (warga dan RT) dapat menambahkan komentar pada setiap pengaduan.

### Responsif UI
- Antarmuka pengguna yang modern dan responsif menggunakan Tailwind CSS, memastikan tampilan yang baik di berbagai perangkat.

### Optimasi Performa (Dasar)
- Penggunaan sistem cache dan antrian (jobs) untuk peningkatan kinerja aplikasi (opsional, perlu konfigurasi lebih lanjut).

## Teknologi yang Digunakan
- **Backend**: PHP (>= 8.2), Laravel Framework (v12.x)
- **Database**: MySQL (>= 8.0)
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js (via Laravel Breeze)
- **Package Tambahan**: Laravel Breeze (untuk scaffolding autentikasi)

## Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk menginstal dan menjalankan proyek di lingkungan pengembangan lokal Anda.

### Prasyarat
- Web server (Apache/Nginx) dengan PHP 8.2 atau lebih tinggi.
- MySQL 8.0 atau lebih tinggi.
- Composer.
- Node.js & npm (atau Yarn).

### Langkah-langkah Instalasi

1. **Clone Repositori**:
   ```bash
   git clone [URL_REPOSITORI_ANDA] rt-rw-pengaduan
   cd rt-rw-pengaduan
   ```
   (Ganti `[URL_REPOSITORI_ANDA]` dengan URL repositori Git Anda jika ada)

2. **Instal Dependensi Composer**:
   ```bash
   composer install
   ```

3. **Buat File Environment (.env)**:
   Salin file `.env.example` dan ganti namanya menjadi `.env`:
   ```bash
   cp .env.example .env
   ```

4. **Konfigurasi Database di .env**:
   Buka file `.env` dan sesuaikan pengaturan database Anda:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pengaduan
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Pastikan database `pengaduan` sudah dibuat di MySQL Anda.

5. **Buat Database MySQL**:
   Buat database dengan nama `pengaduan` di server MySQL Anda (misalnya melalui phpMyAdmin atau terminal MySQL):
   ```sql
   CREATE DATABASE pengaduan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

6. **Jalankan Migrasi Database**:
   Ini akan membuat semua tabel yang dibutuhkan di database `pengaduan`:
   ```bash
   php artisan migrate
   ```

7. **Buat Symbolic Link untuk Storage** (untuk upload lampiran):
   ```bash
   php artisan storage:link
   ```

8. **Instal Dependensi Node.js & Kompilasi Aset Frontend**:
   ```bash
   npm install
   npm run dev
   # atau npm run build untuk produksi
   ```

9. **Jalankan Aplikasi**:
   ```bash
   php artisan serve
   ```
   Aplikasi akan tersedia di `http://127.0.0.1:8000` (atau port lain yang ditampilkan).

## Penggunaan Aplikasi

### Registrasi Pengguna
1. Akses URL aplikasi Anda (`http://127.0.0.1:8000`). Anda akan diarahkan ke halaman login.
2. Klik link "Register" atau akses langsung `/register`.
3. Isi data registrasi, termasuk pilihan peran (Warga atau Ketua RT).
4. **Catatan Keamanan**: Untuk produksi, disarankan agar peran 'Ketua RT' tidak dapat dipilih melalui registrasi publik. Akun Ketua RT sebaiknya dibuat secara manual atau via seeder oleh administrator.

### Login Pengguna
1. Akses URL aplikasi Anda (`http://127.0.0.1:8000`).
2. Gunakan email dan password dari akun yang sudah terdaftar.

### Roles (Peran)
- **Warga**:
  - Dapat membuat dan melihat pengaduan mereka sendiri.
  - Dapat menambahkan komentar pada pengaduan.
- **Ketua RT**:
  - Memiliki akses ke dashboard ringkasan semua pengaduan.
  - Dapat melihat, memproses, dan menyelesaikan semua pengaduan.
  - Dapat mengelola kategori pengaduan (menambah, mengedit, menghapus).

### Data Default (Seeding)
Anda dapat membuat data pengguna awal (misalnya akun RT) menggunakan seeder:
1. Buka `database/seeders/PenggunaSeeder.php` dan sesuaikan jika diperlukan.
2. Jalankan seeder:
   ```bash
   php artisan db:seed --class=PenggunaSeeder
   # Atau, untuk membersihkan database dan mengisi ulang dengan seeder:
   # php artisan migrate:fresh --seed
   ```

## Struktur Proyek

Berikut adalah gambaran struktur direktori dan file kunci dalam proyek ini:

```
rt-rw-pengaduan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/             # Controller untuk autentikasi (dari Breeze)
│   │   │   │   └── RegisteredUserController.php
│   │   │   ├── PengaduanController.php # Controller utama untuk pengaduan
│   │   │   ├── KategoriController.php  # Controller untuk manajemen kategori
│   │   │   └── KomentarController.php  # Controller untuk komentar
│   │   └── Kernel.php            # Konfigurasi middleware utama
│   ├── Models/
│   │   ├── Pengguna.php          # Model untuk user (warga/RT)
│   │   ├── Kategori.php          # Model untuk kategori pengaduan
│   │   ├── Pengaduan.php         # Model untuk pengaduan
│   │   └── Komentar.php          # Model untuk komentar pengaduan
│   └── Providers/
│       └── RouteServiceProvider.php # Konfigurasi home route setelah login
├── bootstrap/
│   └── cache/                    # Folder cache aplikasi (dibersihkan dengan optimize:clear)
├── config/
│   └── auth.php                  # Konfigurasi autentikasi (ubah model ke Pengguna)
├── database/
│   ├── migrations/               # File migrasi database
│   │   ├── YYYY_MM_DD_..._create_users_table.php (bisa juga pengguna)
│   │   ├── YYYY_MM_DD_..._create_sessions_table.php (untuk session database)
│   │   ├── YYYY_MM_DD_..._create_jobs_table.php (untuk queue/job)
│   │   ├── YYYY_MM_DD_..._create_kategori_table.php
│   │   ├── YYYY_MM_DD_..._create_pengaduan_table.php
│   │   └── YYYY_MM_DD_..._create_komentar_table.php
│   └── seeders/                  # File seeder untuk mengisi data awal
│       └── PenggunaSeeder.php
├── public/
│   ├── build/                    # Aset frontend yang dikompilasi (JS/CSS)
│   └── storage/                  # Symbolic link ke storage/app/public
├── resources/
│   ├── css/
│   ├── js/
│   ├── views/
│   │   ├── auth/                 # Tampilan autentikasi (login, register, dll.)
│   │   │   └── register.blade.php # View register (tambahkan pilihan role)
│   │   ├── dashboard/            # Tampilan dashboard
│   │   │   ├── rt.blade.php      # Dashboard Ketua RT
│   │   │   └── warga.blade.php   # Dashboard Warga
│   │   ├── kategori/             # Tampilan manajemen kategori
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── layouts/              # Layout Blade utama (dari Breeze)
│   │   │   └── app.blade.php
│   │   ├── pengaduan/            # Tampilan manajemen pengaduan
│   │   │   ├── index.blade.php
│   │   │   ├── my_pengaduans.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── show.blade.php
│   │   │   └── edit.blade.php
│   │   └── welcome.blade.php     # Halaman selamat datang default
│   └── views/
├── routes/
│   ├── api.php
│   └── web.php                   # Definisi rute utama aplikasi
├── storage/                      # Penyimpanan file (misal: upload lampiran)
│   └── app/
│       └── public/               # File yang bisa diakses publik (lampiran pengaduan)
├── .env                          # Konfigurasi environment lokal
├── composer.json                 # Konfigurasi dependensi Composer
├── package.json                  # Konfigurasi dependensi Node.js
└── vite.config.js                # Konfigurasi Vite (compiler frontend)
```

## Kelompok
1. Rio Firman Raharja (1203230001)
2. Setiawan Muhammad (1203230016)
3. Muhammad Afzal (1203230039)
4. Imam Prasetyo Suherman (1203230043)
