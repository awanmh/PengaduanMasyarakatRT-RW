# Platform Pengaduan Masyarakat Tingkat RT/RW

Platform ini merupakan sistem berbasis web yang memungkinkan warga menyampaikan pengaduan atau keluhan kepada pengurus RT/RW secara langsung, transparan, dan terorganisir.

## 📌 Fitur Utama

- Registrasi dan login warga serta admin
- Pengelolaan data pengaduan masyarakat
- Kategori pengaduan
- Komentar dan tanggapan dari admin
- Manajemen peran pengguna (admin & warga)

---

## ⚙️ Teknologi yang Digunakan

- **Backend:** Laravel 10
- **Database:** MySQL
- **Frontend:** Blade (Laravel), Bootstrap (opsional)
- **Dev Tools:** Laravel Artisan CLI, Composer, VSCode

---

## 🛠️ Langkah Setup Proyek

### 1. Clone Repository

```bash
git clone https://github.com/nama-anda/rt-rw-pengaduan.git
cd rt-rw-pengaduan
```

### 2. Install Dependency

```bash
composer install
```

### 3. Konfigurasi Environment

Buat file `.env` dari template:

```bash
cp .env.example .env
```

Edit bagian koneksi database:

```
DB_DATABASE=rt_rw_pengaduan
DB_USERNAME=root
DB_PASSWORD=  # (sesuaikan dengan password MySQL Anda)
```

### 4. Generate Key

```bash
php artisan key:generate
```

---

## 🗃️ Migrasi dan Seeder

### 5. Jalankan Migrasi

```bash
php artisan migrate
```

Jika ingin rollback & migrasi ulang:

```bash
php artisan migrate:fresh
```

### 6. Tambah Data Dummy (Opsional)

Jalankan seeder (pastikan sudah menambahkan seeder seperti `UserSeeder`):

```bash
php artisan db:seed
```

---

## 🚀 Menjalankan Proyek

```bash
php artisan serve
```

Akses di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🗂️ Struktur Folder Utama

```
app/
├── Models/
│   └── Pengaduan.php, Kategori.php, Comment.php, User.php
├── Http/
│   └── Controllers/
│       └── PengaduanController.php, KategoriController.php
routes/
└── web.php
resources/
└── views/
    └── pengaduan/, auth/, layouts/
```

---

## 👥 Roles dan Hak Akses

| Role  | Akses                                          |
|-------|------------------------------------------------|
| Warga | Buat pengaduan, lihat status, tambah komentar  |
| Admin | Kelola pengaduan, kategori, komentar, dan user |

---

## 🧪 Testing (Manual)

1. Register sebagai warga
2. Login dan kirim pengaduan
3. Login sebagai admin dan tanggapi pengaduan
4. Cek komentar dan status pengaduan

---

## 📄 Lisensi

Proyek ini dibuat untuk kebutuhan akademik dan pengembangan internal. Tidak untuk keperluan komersial.

---

## ✍️ Kontributor

- Nama Anda - Backend & Struktur Database
- (Tambahkan nama jika proyek ini kolaboratif)