<?php

namespace App\Http\Controllers;

use App\Models\Kategori; // Pastikan model Kategori di-import
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // Untuk otorisasi role

class KategoriController extends Controller
{
    /**
     * Konstruktor untuk menerapkan middleware 'auth'
     * dan otorisasi role untuk semua metode di controller ini.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan pengguna sudah login
        // Otorisasi role: hanya RT yang bisa mengakses KategoriController
        // Karena otorisasi role sekarang ditangani di controller,
        // kita tambahkan pengecekan ini di konstruktor atau di setiap metode.
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'RT') {
                abort(403, 'Akses Ditolak: Hanya Ketua RT yang dapat mengelola kategori.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar semua kategori.
     *
     * @return View
     */
    public function index(): View
    {
        $kategoris = Kategori::latest()->get(); // Ambil semua kategori terbaru
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Menampilkan formulir untuk membuat kategori baru.
     *
     * @return View
     */
    public function create(): View
    {
        return view('kategori.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100|unique:kategori,nama', // Nama kategori harus unik
        ]);

        Kategori::create($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu kategori.
     * (Untuk kategori, metode show mungkin tidak selalu diperlukan karena hanya nama)
     *
     * @param Kategori $kategori
     * @return View
     */
    public function show(Kategori $kategori): View
    {
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Menampilkan formulir untuk mengedit kategori.
     *
     * @param Kategori $kategori
     * @return View
     */
    public function edit(Kategori $kategori): View
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui kategori di database.
     *
     * @param Request $request
     * @param Kategori $kategori
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100|unique:kategori,nama,' . $kategori->id, // Unik kecuali untuk kategori itu sendiri
        ]);

        $kategori->update($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus kategori dari database.
     *
     * @param Kategori $kategori
     * @return RedirectResponse
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        // Peringatan: Sebelum menghapus kategori, pastikan tidak ada pengaduan yang menggunakan kategori ini.
        // Anda bisa menambahkan pengecekan di sini, atau mengatur ON DELETE RESTRICT/SET NULL di migrasi database.
        // Karena di migrasi kita pakai ON DELETE RESTRICT, ini akan otomatis mencegah penghapusan jika ada relasi.
        try {
            $kategori->delete();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani error jika ada pengaduan yang masih terkait dengan kategori ini
            return redirect()->route('kategori.index')->with('error', 'Tidak dapat menghapus kategori karena masih ada pengaduan yang terkait.');
        }
    }
}
