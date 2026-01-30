<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BarangMasukController extends Controller
{
    public function index(): View
    {
        $barangMasuks = BarangMasuk::with('barang.kategori', 'barang.ruangan')
            ->latest('tanggal_masuk')
            ->paginate(10);
            
        return view('barangmasuk.index', compact('barangMasuks'));
    }

    public function create(): View
    {
        $barangs = Barang::with(['kategori', 'ruangan'])
            ->orderBy('nama_barang')
            ->get();
        
        return view('barangmasuk.create', compact('barangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'tanggal_masuk' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'barang_id.required' => 'Barang harus dipilih',
            'barang_id.exists' => 'Barang tidak valid',
            'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.min' => 'Jumlah minimal 1',
        ]);

        // Tambah stok barang
        $barang = Barang::findOrFail($validated['barang_id']);
        $barang->tambahStok($validated['jumlah']);

        // Simpan data barang masuk
        BarangMasuk::create($validated);

        return redirect()
            ->route('barangmasuk.index')
            ->with('success', 'Barang masuk berhasil ditambahkan! Stok bertambah ' . $validated['jumlah']);
    }

    public function show(BarangMasuk $barangmasuk): View
    {
        $barangmasuk->load(['barang.kategori', 'barang.ruangan']);
        
        return view('barangmasuk.show', compact('barangmasuk'));
    }

    public function edit(BarangMasuk $barangmasuk): View
    {
        $barangs = Barang::with(['kategori', 'ruangan'])
            ->orderBy('nama_barang')
            ->get();
        
        return view('barangmasuk.edit', compact('barangmasuk', 'barangs'));
    }

    public function update(Request $request, BarangMasuk $barangmasuk): RedirectResponse
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'tanggal_masuk' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'barang_id.required' => 'Barang harus dipilih',
            'barang_id.exists' => 'Barang tidak valid',
            'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.min' => 'Jumlah minimal 1',
        ]);

        // Get old barang
        $oldBarang = Barang::findOrFail($barangmasuk->barang_id);
        
        // Kembalikan stok lama
        $oldBarang->kurangiStok($barangmasuk->jumlah);

        // Tambah stok baru
        $newBarang = Barang::findOrFail($validated['barang_id']);
        $newBarang->tambahStok($validated['jumlah']);

        // Update barang masuk
        $barangmasuk->update($validated);

        return redirect()
            ->route('barangmasuk.index')
            ->with('success', 'Barang masuk berhasil diperbarui!');
    }

    public function destroy(BarangMasuk $barangmasuk): RedirectResponse
    {
        // Kurangi stok
        $barang = Barang::findOrFail($barangmasuk->barang_id);
        $barang->kurangiStok($barangmasuk->jumlah);

        $barangmasuk->delete();

        return redirect()
            ->route('barangmasuk.index')
            ->with('success', 'Barang masuk berhasil dihapus! Stok dikurangi ' . $barangmasuk->jumlah);
    }
}