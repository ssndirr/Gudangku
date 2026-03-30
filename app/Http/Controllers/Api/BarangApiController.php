<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class BarangApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Barang::with(['kategori','ruangan'])->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255|unique:barangs',
            'kategori_id' => 'required|exists:kategoris,id',
            'ruangan_id' => 'required|exists:ruangans,id',
        ]);
        
        $barang = Barang::create([
            ...$validated,
            'stok' => 0,
        ]);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang
        ], 201);
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori','ruangan'])->findOrFail($id);

        return response()->json([
            'data' => $barang
        ]);
    }

    public function update(Request $request, $id)
{
    $barang = Barang::findOrFail($id); 

    $validated = $request->validate([
        'nama_barang' => 'required|string|max:255|unique:barangs,nama_barang,' . $id,
        'kategori_id' => 'required|exists:kategoris,id',
        'ruangan_id' => 'required|exists:ruangans,id',
    ]);
    
    $barang->update($validated);

    return response()->json([
        'message' => 'Barang berhasil diperbarui',
        'data' => $barang
    ]);
}


    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->barangMasuks()->exists() || $barang->barangKeluars()->exists()) {
            return response()->json([
                'message' => 'Barang memiliki riwayat transaksi'
            ], 422);
        }

        $barang->delete();

        return response()->json([
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}
