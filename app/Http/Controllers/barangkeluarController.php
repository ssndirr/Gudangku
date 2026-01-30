<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BarangKeluarController extends Controller
{
    public function index(): View
    {
        $barangKeluars = BarangKeluar::with('barang.kategori', 'barang.ruangan')
            ->latest('tanggal_keluar')
            ->paginate(10);
            
        return view('barangkeluar.index', compact('barangKeluars'));
    }

    public function create(): View
    {
        $barangs = Barang::with(['kategori', 'ruangan'])
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();
        
        return view('barangkeluar.create', compact('barangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'tanggal_keluar' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'barang_id.required' => 'Barang harus dipilih',
            'barang_id.exists' => 'Barang tidak valid',
            'tanggal_keluar.required' => 'Tanggal keluar tidak boleh kosong',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.min' => 'Jumlah minimal 1',
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);

        // Cek stok cukup
        if (!$barang->isStokTersedia($validated['jumlah'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $barang->stok);
        }

        // Kurangi stok
        $barang->kurangiStok($validated['jumlah']);

        // Simpan data barang keluar
        BarangKeluar::create($validated);

        return redirect()
            ->route('barangkeluar.index')
            ->with('success', 'Barang keluar berhasil ditambahkan! Stok berkurang ' . $validated['jumlah']);
    }

    public function show(BarangKeluar $barangkeluar): View
    {
        $barangkeluar->load(['barang.kategori', 'barang.ruangan']);
        
        return view('barangkeluar.show', compact('barangkeluar'));
    }

    public function edit(BarangKeluar $barangkeluar): View
    {
        $barangs = Barang::with(['kategori', 'ruangan'])
            ->orderBy('nama_barang')
            ->get();
        
        return view('barangkeluar.edit', compact('barangkeluar', 'barangs'));
    }

    public function update(Request $request, BarangKeluar $barangkeluar): RedirectResponse
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'tanggal_keluar' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'barang_id.required' => 'Barang harus dipilih',
            'barang_id.exists' => 'Barang tidak valid',
            'tanggal_keluar.required' => 'Tanggal keluar tidak boleh kosong',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.min' => 'Jumlah minimal 1',
        ]);

        // Get old barang
        $oldBarang = Barang::findOrFail($barangkeluar->barang_id);
        
        // Kembalikan stok lama
        $oldBarang->tambahStok($barangkeluar->jumlah);

        // Kurangi stok baru
        $newBarang = Barang::findOrFail($validated['barang_id']);
        
        // Cek stok cukup
        if (!$newBarang->isStokTersedia($validated['jumlah'])) {
            // Kembalikan lagi stok yang sudah ditambah
            $oldBarang->kurangiStok($barangkeluar->jumlah);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $newBarang->stok);
        }

        $newBarang->kurangiStok($validated['jumlah']);

        // Update barang keluar
        $barangkeluar->update($validated);

        return redirect()
            ->route('barangkeluar.index')
            ->with('success', 'Barang keluar berhasil diperbarui!');
    }

    public function destroy(BarangKeluar $barangkeluar): RedirectResponse
    {
        // Kembalikan stok
        $barang = Barang::findOrFail($barangkeluar->barang_id);
        $barang->tambahStok($barangkeluar->jumlah);

        $barangkeluar->delete();

        return redirect()
            ->route('barangkeluar.index')
            ->with('success', 'Barang keluar berhasil dihapus! Stok dikembalikan ' . $barangkeluar->jumlah);
    }
}