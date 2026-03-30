<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangMasukApiController extends Controller
{
    public function index()
    {
        return response()->json(
            BarangMasuk::with('barang.kategori', 'barang.ruangan')
                ->latest('tanggal_masuk')
                ->get()
        );
    }

    public function show($id)
    {
        $barangMasuk = BarangMasuk::with('barang.kategori', 'barang.ruangan')
            ->findOrFail($id);

        return response()->json($barangMasuk);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id'     => ['required', 'exists:barangs,id'],
            'tanggal_masuk' => ['required', 'date'],
            'jumlah'        => ['required', 'integer', 'min:1'],
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);

        // Tambah stok
        $barang->tambahStok($validated['jumlah']);

        $barangMasuk = BarangMasuk::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Barang masuk berhasil',
            'data' => $barangMasuk
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $validated = $request->validate([
            'barang_id'     => ['required', 'exists:barangs,id'],
            'tanggal_masuk' => ['required', 'date'],
            'jumlah'        => ['required', 'integer', 'min:1'],
        ]);

        // Rollback stok lama
        $oldBarang = Barang::findOrFail($barangMasuk->barang_id);
        $oldBarang->kurangiStok($barangMasuk->jumlah);

        // Tambah stok baru
        $newBarang = Barang::findOrFail($validated['barang_id']);
        $newBarang->tambahStok($validated['jumlah']);

        // Update data
        $barangMasuk->update($validated);

        return response()->json([
            'message' => 'Barang masuk berhasil diperbarui',
            'data' => $barangMasuk
        ]);
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Rollback stok
        $barang = Barang::findOrFail($barangMasuk->barang_id);
        $barang->kurangiStok($barangMasuk->jumlah);

        $barangMasuk->delete();

        return response()->json([
            'message' => 'Barang masuk berhasil dihapus'
        ]);
    }
}
