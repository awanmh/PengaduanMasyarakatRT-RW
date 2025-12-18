<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

// Jangan uncomment ini kecuali Anda sudah membuat job SendNotificationEmail
// use App\Jobs\SendNotificationEmail;

class PengaduanController extends Controller
{
    /**
     * Konstruktor untuk menerapkan middleware 'auth' ke semua metode di controller ini.
     * Pengguna harus login untuk mengakses fitur-fitur pengaduan.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar semua pengaduan dengan pagination.
     * Tampilan berbeda untuk RT (semua pengaduan) dan Warga (pengaduan mereka sendiri).
     *
     * @return View
     */
    public function index(): View
    {
        $perPage = 15; // Jumlah item per halaman
        
        // Memuat relasi 'pengguna' dan 'kategori' untuk menghindari N+1 query problem
        if (Auth::user()->role === 'RT') {
            // RT dapat melihat semua pengaduan
            $pengaduans = Pengaduan::with(['pengguna', 'kategori'])->latest()->paginate($perPage);
        } else { // Warga
            // Warga hanya dapat melihat pengaduan yang mereka buat
            $pengaduans = Auth::user()->pengaduans()->with('kategori')->latest()->paginate($perPage);
        }

        return view('pengaduan.index', compact('pengaduans'));
    }

    /**
     * Menampilkan formulir untuk membuat pengaduan baru.
     * Hanya dapat diakses oleh pengguna dengan peran 'warga'.
     *
     * @return View
     */
    public function create(): View
    {
        // Verifikasi role: hanya warga yang bisa membuat pengaduan
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses Ditolak: Hanya warga yang dapat membuat pengaduan.');
        }

        // Ambil semua kategori untuk dropdown di form
        $kategoris = Kategori::all();

        return view('pengaduan.create', compact('kategoris'));
    }

    /**
     * Menyimpan pengaduan baru ke database.
     * Hanya dapat diakses oleh pengguna dengan peran 'warga'.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Verifikasi role: hanya warga yang bisa membuat pengaduan
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses Ditolak: Hanya warga yang dapat membuat pengaduan.');
        }

        // Validasi input dari form
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id', // Pastikan kategori_id ada di tabel kategori
            'lampiran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Lampiran opsional, hanya gambar, max 2MB
        ]);

        // Set user_id dari pengguna yang sedang login
        $validatedData['user_id'] = Auth::id();

        // Penanganan upload file lampiran
        if ($request->hasFile('lampiran')) {
            // Simpan file di direktori 'storage/app/public/lampiran_pengaduan'
            // dan simpan path-nya di database
            $validatedData['lampiran'] = $request->file('lampiran')->store('lampiran_pengaduan', 'public');
        }

        // Buat entri pengaduan baru di database
        $pengaduan = Pengaduan::create($validatedData);

        // Opsional: Dispatch notifikasi ke semua user RT (asynchronous)
        // Pastikan Anda sudah membuat Job 'SendNotificationEmail' jika ingin menggunakan ini
        /*
        $rtUsers = Pengguna::where('role', 'RT')->get();
        foreach ($rtUsers as $rtUser) {
            SendNotificationEmail::dispatch($pengaduan, $rtUser, 'new_pengaduan');
        }
        */

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dibuat!');
    }

    /**
     * Menampilkan detail satu pengaduan beserta komentarnya.
     * Dapat diakses oleh pembuat pengaduan atau oleh RT.
     *
     * @param Pengaduan $pengaduan Model Pengaduan yang diresolve secara otomatis oleh Laravel
     * @return View
     */
    public function show(Pengaduan $pengaduan): View
    {
        // Verifikasi otorisasi: hanya pembuat atau RT yang bisa melihat detail
        if (Auth::user()->id !== $pengaduan->user_id && Auth::user()->role !== 'RT') {
            abort(403, 'Anda tidak memiliki akses untuk melihat pengaduan ini.');
        }

        // Muat relasi yang diperlukan: komentar beserta penggunanya, pengaduan's pengguna, dan kategori
        $pengaduan->load(['komentars.pengguna', 'pengguna', 'kategori']);

        return view('pengaduan.show', compact('pengaduan'));
    }

    /**
     * Menampilkan formulir untuk mengedit pengaduan.
     * Biasanya hanya dapat diakses oleh pembuat pengaduan atau RT/admin.
     *
     * @param Pengaduan $pengaduan
     * @return View|RedirectResponse
     */
    public function edit(Pengaduan $pengaduan): View|RedirectResponse
    {
        // Contoh otorisasi: hanya pembuat pengaduan yang bisa mengedit, atau RT
        if (Auth::user()->id !== $pengaduan->user_id && Auth::user()->role !== 'RT') {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengedit pengaduan ini.');
        }

        // Jika status sudah diproses atau selesai, mungkin tidak boleh diubah
        // Kecuali oleh RT
        if ($pengaduan->status !== 'pending' && Auth::user()->role !== 'RT') {
            return redirect()->route('pengaduan.show', $pengaduan->id)->with('error', 'Pengaduan tidak bisa diubah karena sudah diproses atau selesai.');
        }

        $kategoris = Kategori::all(); // Ambil kategori untuk dropdown

        return view('pengaduan.edit', compact('pengaduan', 'kategoris'));
    }

    /**
     * Memperbarui data pengaduan di database.
     *
     * @param Request $request
     * @param Pengaduan $pengaduan
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        // Contoh otorisasi: hanya pembuat pengaduan yang bisa update, atau RT
        if (Auth::user()->id !== $pengaduan->user_id && Auth::user()->role !== 'RT') {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk memperbarui pengaduan ini.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'lampiran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Penanganan upload lampiran baru
        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($pengaduan->lampiran) {
                Storage::disk('public')->delete($pengaduan->lampiran);
            }
            $validatedData['lampiran'] = $request->file('lampiran')->store('lampiran_pengaduan', 'public');
        } else {
            // Jika tidak ada upload baru, pertahankan lampiran lama
            $validatedData['lampiran'] = $pengaduan->lampiran;
        }

        $pengaduan->update($validatedData);

        return redirect()->route('pengaduan.show', $pengaduan->id)->with('success', 'Pengaduan berhasil diperbarui!');
    }

    /**
     * Menghapus pengaduan dari database.
     * Biasanya hanya untuk RT/Admin atau pembuat pengaduan.
     *
     * @param Pengaduan $pengaduan
     * @return RedirectResponse
     */
    public function destroy(Pengaduan $pengaduan): RedirectResponse
    {
        if (Auth::user()->id !== $pengaduan->user_id && Auth::user()->role !== 'RT') {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk menghapus pengaduan ini.');
        }

        if ($pengaduan->lampiran) {
            Storage::disk('public')->delete($pengaduan->lampiran);
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    /**
     * Memperbarui status pengaduan (khusus untuk peran 'RT').
     *
     * @param Request $request
     * @param Pengaduan $pengaduan
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        if (Auth::user()->role !== 'RT') {
            abort(403, 'Akses Ditolak: Hanya RT yang dapat memperbarui status.');
        }

        $validatedData = $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pengaduan->update(['status' => $validatedData['status']]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }

    /**
     * Menampilkan dashboard khusus untuk pengguna dengan peran 'RT'.
     *
     * @return View
     */
    public function dashboardRT(): View
    {
        if (Auth::user()->role !== 'RT') {
            abort(403, 'Akses Ditolak: Hanya untuk RT.');
        }

        $totalPengaduan = Pengaduan::count();
        $pendingPengaduan = Pengaduan::where('status', 'pending')->count();
        $prosesPengaduan = Pengaduan::where('status', 'proses')->count();
        $selesaiPengaduan = Pengaduan::where('status', 'selesai')->count();

        // Ambil beberapa pengaduan terbaru dengan pagination
        $latestPengaduans = Pengaduan::with(['pengguna', 'kategori'])->latest()->paginate(5); // 5 per halaman untuk dashboard

        return view('dashboard.rt', compact('totalPengaduan', 'pendingPengaduan', 'prosesPengaduan', 'selesaiPengaduan', 'latestPengaduans'));
    }

    /**
     * Menampilkan dashboard khusus untuk pengguna dengan peran 'warga'.
     *
     * @return View
     */
    public function dashboardWarga(): View
    {
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses Ditolak: Hanya untuk Warga.');
        }

        $myTotalPengaduan = Auth::user()->pengaduans()->count();
        $myPendingPengaduan = Auth::user()->pengaduans()->where('status', 'pending')->count();
        $myProsesPengaduan = Auth::user()->pengaduans()->where('status', 'proses')->count();
        $mySelesaiPengaduan = Auth::user()->pengaduans()->where('status', 'selesai')->count();

        // Ambil beberapa pengaduan terbaru yang dibuat oleh warga ini dengan pagination
        $latestMyPengaduans = Auth::user()->pengaduans()->with('kategori')->latest()->paginate(5); // 5 per halaman untuk dashboard

        return view('dashboard.warga', compact('myTotalPengaduan', 'myPendingPengaduan', 'myProsesPengaduan', 'mySelesaiPengaduan', 'latestMyPengaduans'));
    }

    /**
     * Menampilkan daftar pengaduan yang dibuat oleh pengguna yang sedang login (warga) dengan pagination.
     *
     * @return View
     */
    public function myPengaduans(): View
    {
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses Ditolak: Hanya untuk Warga.');
        }
        $pengaduans = Auth::user()->pengaduans()->with('kategori')->latest()->paginate(15); // 15 per halaman
        return view('pengaduan.my_pengaduans', compact('pengaduans'));
    }
}
