<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $user = auth()->user();
    
        $kategoris = Kategori::all();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get(); // PENTING: Kirim ruangans
    
        // QUERY DASAR
        $query = Barang::with(['kategori', 'ruangan']);
    
        // 🔐 JIKA BUKAN ADMIN → FILTER RUANGAN
        if ($user->role !== 'admin') {
            $query->where('ruangan_id', $user->ruangan_id);
        }
    
        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
    
        // Filter nama barang
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', "%{$request->search}%");
        }
    
        $barangs = $query->paginate(12);
    
        return view('home', compact('barangs', 'kategoris', 'ruangans'));
    }
    
    public function show(Barang $barang): View
    {
        // Custom data untuk tampilan
        $customData = [
            'id' => $barang->id,
            'nama_barang' => $barang->nama_barang,
            'kategori' => $barang->kategori->nama_kategori ?? 'Tanpa Kategori',
            'ruangan' => $barang->ruangan->nama_ruangan ?? 'Tanpa Ruangan',
            'lokasi' => $barang->ruangan->lokasi ?? '-',
            'stok' => $barang->stok,
            'deskripsi' => 'Informasi lengkap tentang ' . $barang->nama_barang
        ];

        return view('homeshow', compact('customData'));
    }

    /**
     * Tampilkan halaman order/transaksi untuk staff
     */
    public function order(Request $request): View
    {
        $user = auth()->user();

        // Hanya staff yang punya ruangan yang bisa akses
        if ($user->role === 'admin' || !$user->ruangan_id) {
            abort(403, 'Halaman ini hanya untuk Staff dengan Ruangan.');
        }

        // Ambil barang sesuai ruangan staff (hanya ruangan sendiri untuk transaksi)
        $barangs = Barang::with(['kategori', 'ruangan'])
            ->where('ruangan_id', $user->ruangan_id)
            ->orderBy('nama_barang')
            ->get();

        // Ambil riwayat transaksi masuk (10 terakhir) dengan user
        $barangMasuks = BarangMasuk::with(['barang.kategori', 'user'])
            ->whereHas('barang', function($query) use ($user) {
                $query->where('ruangan_id', $user->ruangan_id);
            })
            ->latest('tanggal_masuk')
            ->take(10)
            ->get();

        // Ambil riwayat transaksi keluar (10 terakhir) dengan user
        $barangKeluars = BarangKeluar::with(['barang.kategori', 'user'])
            ->whereHas('barang', function($query) use ($user) {
                $query->where('ruangan_id', $user->ruangan_id);
            })
            ->latest('tanggal_keluar')
            ->take(10)
            ->get();

        return view('homeorder', compact('barangs', 'barangMasuks', 'barangKeluars'));
    }

    /**
     * Simpan transaksi barang masuk dari staff
     */
    public function storeBarangMasuk(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Validasi
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'tanggal_masuk' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'barang_id.required' => 'Barang harus dipilih',
            'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.min' => 'Jumlah minimal 1',
        ]);

        // Cek apakah barang sesuai dengan ruangan staff
        $barang = Barang::findOrFail($validated['barang_id']);
        
        if ($barang->ruangan_id !== $user->ruangan_id) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak bisa menambah barang dari ruangan lain!');
        }

        // Tambah stok
        $barang->tambahStok($validated['jumlah']);

        // Simpan transaksi dengan user_id
        BarangMasuk::create([
            'barang_id' => $validated['barang_id'],
            'user_id' => $user->id,
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'jumlah' => $validated['jumlah'],
        ]);

        return redirect()
            ->route('home.order')
            ->with('success', 'Barang masuk berhasil ditambahkan! Stok bertambah ' . $validated['jumlah']);
    }

    /**
     * Simpan transaksi barang keluar dari staff
     */
    public function storeBarangKeluar(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Validasi
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'tanggal_keluar' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'barang_id.required' => 'Barang harus dipilih',
            'tanggal_keluar.required' => 'Tanggal keluar tidak boleh kosong',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.min' => 'Jumlah minimal 1',
        ]);

        // Cek apakah barang sesuai dengan ruangan staff
        $barang = Barang::findOrFail($validated['barang_id']);
        
        if ($barang->ruangan_id !== $user->ruangan_id) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak bisa mengeluarkan barang dari ruangan lain!');
        }

        // Cek stok
        if (!$barang->isStokTersedia($validated['jumlah'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $barang->stok);
        }

        // Kurangi stok
        $barang->kurangiStok($validated['jumlah']);

        // Simpan transaksi dengan user_id
        BarangKeluar::create([
            'barang_id' => $validated['barang_id'],
            'user_id' => $user->id,
            'tanggal_keluar' => $validated['tanggal_keluar'],
            'jumlah' => $validated['jumlah'],
        ]);

        return redirect()
            ->route('home.order')
            ->with('success', 'Barang keluar berhasil ditambahkan! Stok berkurang ' . $validated['jumlah']);
    }
}