<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    // Menampilkan semua pengaduan milik user login
    public function index()
    {
        $pengaduans = Pengaduan::with('kategori')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pengaduan.index', compact('pengaduans'));
    }

    // Form buat pengaduan baru
    public function create()
    {
        $kategoris = Kategori::all();
        return view('pengaduan.create', compact('kategoris'));
    }

    // Simpan pengaduan baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        Pengaduan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
            'status' => 'pending',
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    // Tampilkan detail pengaduan
    public function show(Pengaduan $pengaduan)
    {
        return view('pengaduan.show', compact('pengaduan'));
    }

    // Edit pengaduan (hanya jika masih pending dan milik user)
    public function edit(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== Auth::id() || $pengaduan->status !== 'pending') {
            abort(403);
        }

        $kategoris = Kategori::all();
        return view('pengaduan.edit', compact('pengaduan', 'kategoris'));
    }

    // Update pengaduan (hanya jika masih pending dan milik user)
    public function update(Request $request, Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== Auth::id() || $pengaduan->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $pengaduan->update($request->only('judul', 'isi', 'kategori_id'));

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    // Hapus pengaduan (hanya jika masih pending dan milik user)
    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== Auth::id() || $pengaduan->status !== 'pending') {
            abort(403);
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    // ========== Fitur Admin (RT) ==========

    // Hanya untuk role RT/Admin, menampilkan semua pengaduan lengkap
public function adminIndex(Request $request)
{
    if (!Auth::user()->hasRole('rt')) {
        abort(403);
    }

    $query = Pengaduan::with('kategori', 'user')->latest();

    // Filter pencarian keyword
    if ($request->filled('search')) {
        $keyword = $request->search;
        $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%$keyword%")
              ->orWhere('isi', 'like', "%$keyword%")
              ->orWhereHas('user', function ($q2) use ($keyword) {
                  $q2->where('name', 'like', "%$keyword%");
              })
              ->orWhereHas('kategori', function ($q3) use ($keyword) {
                  $q3->where('nama', 'like', "%$keyword%");
              });
        });
    }

    // Filter berdasarkan status
    if ($request->filled('status') && in_array($request->status, ['pending', 'proses', 'selesai'])) {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan kategori_id
    if ($request->filled('kategori_id')) {
        $query->where('kategori_id', $request->kategori_id);
    }

    // Filter berdasarkan rentang tanggal (created_at)
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    $pengaduans = $query->get();

    // Untuk select kategori di form filter
    $kategoris = Kategori::all();

    return view('pengaduan.admin_index', compact('pengaduans', 'kategoris'));
}

    // Update status pengaduan oleh RT/Admin
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::user()->hasRole('rt')) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->save();

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
