<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('barang')->get();
        return view('barangkeluar.index', compact('barangKeluar'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('barangkeluar.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'      => 'required',
            'tanggal_keluar' => 'required|date',
            'jumlah'         => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Cek stok cukup
        if ($request->jumlah > $barang->stok) {
            return redirect()->back()->with('error', 'Jumlah keluar melebihi stok yang tersedia');
        }

        // Kurangi stok
        $barang->stok -= $request->jumlah;
        $barang->save();

        // Simpan data Barang Keluar
        BarangKeluar::create([
            'barang_id'      => $request->barang_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jumlah'         => $request->jumlah,
        ]);

        return redirect()->route('barangkeluar.index')
            ->with('success', 'Data Barang Keluar Berhasil Ditambahkan dan Stok Berkurang');
    }

    public function show($id)
    {
        $barangKeluar = BarangKeluar::with('barang')->findOrFail($id);
        return view('barangkeluar.show', compact('barangKeluar'));
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = Barang::all();

        return view('barangkeluar.edit', compact('barangKeluar', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id'      => 'required',
            'tanggal_keluar' => 'required|date',
            'jumlah'         => 'required|integer|min:1',
        ]);

        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = Barang::findOrFail($request->barang_id);

        // Update stok: kembalikan stok lama, kurangi stok baru
        $barang->stok = $barang->stok + $barangKeluar->jumlah - $request->jumlah;

        // Pastikan stok tidak negatif
        if ($barang->stok < 0) {
            return redirect()->back()->with('error', 'Jumlah keluar melebihi stok yang tersedia');
        }

        $barang->save();

        $barangKeluar->update([
            'barang_id'      => $request->barang_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jumlah'         => $request->jumlah,
        ]);

        return redirect()->route('barangkeluar.index')
            ->with('success', 'Data Barang Keluar Berhasil Diubah dan Stok Terupdate');
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = Barang::findOrFail($barangKeluar->barang_id);

        // Kembalikan stok saat data dihapus
        $barang->stok += $barangKeluar->jumlah;
        $barang->save();

        $barangKeluar->delete();

        return redirect()->route('barangkeluar.index')
            ->with('success', 'Data Barang Keluar Berhasil Dihapus dan Stok Dikembalikan');
    }
}
