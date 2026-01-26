<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik
        $totalUsers = User::count();
        $totalKategori = Kategori::count();
        $totalBarang = Barang::count();
        $barangMasukBulanIni = BarangMasuk::whereMonth('tanggal_masuk', date('m'))
            ->whereYear('tanggal_masuk', date('Y'))
            ->sum('jumlah');
        $barangKeluarBulanIni = BarangKeluar::whereMonth('tanggal_keluar', date('m'))
            ->whereYear('tanggal_keluar', date('Y'))
            ->sum('jumlah');

        // Transaksi terbaru (gabungkan masuk & keluar)
        $recentTransactions = collect()
            ->merge(
                BarangMasuk::latest()->take(5)->get()->map(function($b) {
                    return (object)[
                        'type' => 'masuk',
                        'barang_name' => $b->barang->nama_barang ?? '-',
                        'tanggal' => $b->tanggal_masuk,
                        'jumlah' => $b->jumlah
                    ];
                })
            )
            ->merge(
                BarangKeluar::latest()->take(5)->get()->map(function($b) {
                    return (object)[
                        'type' => 'keluar',
                        'barang_name' => $b->barang->nama_barang ?? '-',
                        'tanggal' => $b->tanggal_keluar,
                        'jumlah' => $b->jumlah
                    ];
                })
            )
            ->sortByDesc('tanggal')
            ->take(5);

        // Barang dengan stok menipis (misal < 5)
        $lowStockItems = Barang::with('kategori')->where('stok', '<', 5)->get()->map(function($b) {
            return (object)[
                'nama' => $b->nama_barang,
                'kategori' => $b->kategori->nama_kategori ?? '-',
                'stok' => $b->stok,
                'min_stok' => 1
            ];
        });

        return view('dashboard', compact(
            'totalUsers', 
            'totalKategori', 
            'totalBarang', 
            'barangMasukBulanIni', 
            'barangKeluarBulanIni', 
            'recentTransactions',
            'lowStockItems'
        ));
    }
}
