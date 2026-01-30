<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik
        $totalUsers = User::count();
        $totalKategori = Kategori::count();
        $totalRuangan = Ruangan::count();
        $totalBarang = Barang::count();
        
        $barangMasukBulanIni = BarangMasuk::whereMonth('tanggal_masuk', date('m'))
            ->whereYear('tanggal_masuk', date('Y'))
            ->sum('jumlah');
            
        $barangKeluarBulanIni = BarangKeluar::whereMonth('tanggal_keluar', date('m'))
            ->whereYear('tanggal_keluar', date('Y'))
            ->sum('jumlah');

        // Transaksi terbaru dengan user dan ruangan
        $recentTransactions = collect()
            ->merge(
                BarangMasuk::with(['barang.ruangan', 'user'])
                    ->latest('tanggal_masuk')
                    ->take(10)
                    ->get()
                    ->map(function($b) {
                        return (object)[
                            'type' => 'masuk',
                            'barang_name' => $b->barang->nama_barang ?? '-',
                            'ruangan' => $b->barang->ruangan->nama_ruangan ?? '-',
                            'user_name' => $b->user->name ?? 'System',
                            'tanggal' => $b->tanggal_masuk,
                            'jumlah' => $b->jumlah,
                            'created_at' => $b->created_at
                        ];
                    })
            )
            ->merge(
                BarangKeluar::with(['barang.ruangan', 'user'])
                    ->latest('tanggal_keluar')
                    ->take(10)
                    ->get()
                    ->map(function($b) {
                        return (object)[
                            'type' => 'keluar',
                            'barang_name' => $b->barang->nama_barang ?? '-',
                            'ruangan' => $b->barang->ruangan->nama_ruangan ?? '-',
                            'user_name' => $b->user->name ?? 'System',
                            'tanggal' => $b->tanggal_keluar,
                            'jumlah' => $b->jumlah,
                            'created_at' => $b->created_at
                        ];
                    })
            )
            ->sortByDesc('created_at')
            ->take(10);

        // Barang dengan stok menipis (< 5)
        $lowStockItems = Barang::with('ruangan')
            ->where('stok', '<', 5)
            ->orderBy('stok', 'asc')
            ->get()
            ->map(function($b) {
                return (object)[
                    'nama' => $b->nama_barang,
                    'ruangan' => $b->ruangan->nama_ruangan ?? '-',
                    'stok' => $b->stok,
                    'min_stok' => 5
                ];
            });

        // Statistik per Ruangan
        $statsPerRuangan = Ruangan::withCount(['barangs'])
            ->with(['barangs' => function($query) {
                $query->select('ruangan_id', DB::raw('SUM(stok) as total_stok'))
                      ->groupBy('ruangan_id');
            }])
            ->get()
            ->map(function($ruangan) {
                // Hitung transaksi masuk bulan ini per ruangan
                $barangMasuk = BarangMasuk::whereHas('barang', function($q) use ($ruangan) {
                    $q->where('ruangan_id', $ruangan->id);
                })
                ->whereMonth('tanggal_masuk', date('m'))
                ->whereYear('tanggal_masuk', date('Y'))
                ->sum('jumlah');

                // Hitung transaksi keluar bulan ini per ruangan
                $barangKeluar = BarangKeluar::whereHas('barang', function($q) use ($ruangan) {
                    $q->where('ruangan_id', $ruangan->id);
                })
                ->whereMonth('tanggal_keluar', date('m'))
                ->whereYear('tanggal_keluar', date('Y'))
                ->sum('jumlah');

                // Total stok
                $totalStok = Barang::where('ruangan_id', $ruangan->id)->sum('stok');

                return (object)[
                    'nama' => $ruangan->nama_ruangan,
                    'lokasi' => $ruangan->lokasi,
                    'total_barang' => $ruangan->barangs_count,
                    'total_stok' => $totalStok,
                    'barang_masuk' => $barangMasuk,
                    'barang_keluar' => $barangKeluar,
                ];
            });

        // Top Contributors (User yang paling banyak transaksi)
        $topContributors = User::withCount(['barangMasuks', 'barangKeluars'])
            ->having(DB::raw('barang_masuks_count + barang_keluars_count'), '>', 0)
            ->orderByDesc(DB::raw('barang_masuks_count + barang_keluars_count'))
            ->take(5)
            ->get()
            ->map(function($user) {
                return (object)[
                    'name' => $user->name,
                    'ruangan' => $user->ruangan->nama_ruangan ?? '-',
                    'total_transaksi' => $user->barang_masuks_count + $user->barang_keluars_count,
                    'barang_masuk' => $user->barang_masuks_count,
                    'barang_keluar' => $user->barang_keluars_count,
                ];
            });

        return view('dashboard', compact(
            'totalUsers', 
            'totalKategori', 
            'totalRuangan', 
            'totalBarang', 
            'barangMasukBulanIni', 
            'barangKeluarBulanIni', 
            'recentTransactions',
            'lowStockItems',
            'statsPerRuangan',
            'topContributors'
        ));
    }
}