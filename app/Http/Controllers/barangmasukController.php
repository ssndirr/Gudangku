<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::all();
        return view('barangmasuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('barangmasuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'     => 'required',
            'tanggal_masuk' => 'required|date',
            'jumlah'        => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Tambah stok barang
        $barang->stok += $request->jumlah;
        $barang->save();

        // Simpan data Barang Masuk
        BarangMasuk::create([
            'barang_id'     => $request->barang_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah'        => $request->jumlah,
        ]);

        return redirect()->route('barangmasuk.index')
            ->with('success', 'Data Barang Masuk Berhasil Ditambahkan dan Stok Barang Bertambah');
    }

    public function show($id)
    {
        $barangmasuk = BarangMasuk::with('barang')->findOrFail($id);
        return view('barangmasuk.show', compact('barangmasuk'));
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barang = Barang::all();

        return view('barangmasuk.edit', compact('barangMasuk', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id'     => 'required',
            'tanggal_masuk' => 'required|date',
            'jumlah'        => 'required|integer|min:1',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);

        // Ambil barang terkait
        $barang = Barang::findOrFail($request->barang_id);

        // Update stok: kurangi stok lama, tambah stok baru
        $barang->stok = $barang->stok - $barangMasuk->jumlah + $request->jumlah;
        $barang->save();

        $barangMasuk->update([
            'barang_id'     => $request->barang_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah'        => $request->jumlah,
        ]);

        return redirect()->route('barangmasuk.index')
            ->with('success', 'Data Barang Masuk Berhasil Diubah dan Stok Barang Terupdate');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Kurangi stok saat data dihapus
        $barang = Barang::findOrFail($barangMasuk->barang_id);
        $barang->stok -= $barangMasuk->jumlah;
        $barang->save();

        $barangMasuk->delete();

        return redirect()->route('barangmasuk.index')
            ->with('success', 'Data Barang Masuk Berhasil Dihapus dan Stok Barang Dikurangi');
    }
}
