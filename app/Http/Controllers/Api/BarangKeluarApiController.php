<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangKeluarApiController extends Controller
{
    public function index()
    {
        return response()->json(
            BarangKeluar::with('barang.kategori', 'barang.ruangan')
                ->latest('tanggal_keluar')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id'      => ['required', 'exists:barangs,id'],
            'tanggal_keluar' => ['required', 'date'],
            'jumlah'         => ['required', 'integer', 'min:1'],
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);

        if (!$barang->isStokTersedia($validated['jumlah'])) {
            return response()->json([
                'message' => 'Stok tidak mencukupi',
                'stok' => $barang->stok
            ], 422);
        }

        $barang->kurangiStok($validated['jumlah']);

        $barangKeluar = BarangKeluar::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Barang keluar berhasil',
            'data' => $barangKeluar
        ], 201);
    }

    public function show($id)
    {
        return response()->json(
            BarangKeluar::with('barang.kategori', 'barang.ruangan')
                ->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $validated = $request->validate([
            'barang_id'      => ['required', 'exists:barangs,id'],
            'tanggal_keluar' => ['required', 'date'],
            'jumlah'         => ['required', 'integer', 'min:1'],
        ]);

        // rollback stok lama
        $oldBarang = Barang::findOrFail($barangKeluar->barang_id);
        $oldBarang->tambahStok($barangKeluar->jumlah);

        $newBarang = Barang::findOrFail($validated['barang_id']);

        if (!$newBarang->isStokTersedia($validated['jumlah'])) {
            $oldBarang->kurangiStok($barangKeluar->jumlah);

            return response()->json([
                'message' => 'Stok tidak mencukupi',
                'stok' => $newBarang->stok
            ], 422);
        }

        $newBarang->kurangiStok($validated['jumlah']);
        $barangKeluar->update($validated);

        return response()->json([
            'message' => 'Barang keluar diperbarui',
            'data' => $barangKeluar
        ]);
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = Barang::findOrFail($barangKeluar->barang_id);

        $barang->tambahStok($barangKeluar->jumlah);
        $barangKeluar->delete();

        return response()->json([
            'message' => 'Barang keluar dihapus'
        ]);
    }
}
