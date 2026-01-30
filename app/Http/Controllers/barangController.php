<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index(): View
    {
        $barangs = Barang::with(['kategori', 'ruangan'])
            ->latest()
            ->paginate(10);
            
        return view('barang.index', compact('barangs'));
    }

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        
        return view('barang.create', compact('kategoris', 'ruangans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'ruangan_id' => ['required', 'exists:ruangans,id'],
        ], [
            'nama_barang.required' => 'Nama barang tidak boleh kosong',
            'kategori_id.required' => 'Kategori harus dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'ruangan_id.required' => 'Ruangan harus dipilih',
            'ruangan_id.exists' => 'Ruangan tidak valid',
        ]);

        Barang::create([
            'nama_barang' => $validated['nama_barang'],
            'kategori_id' => $validated['kategori_id'],
            'ruangan_id' => $validated['ruangan_id'],
            'stok' => 0,
        ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show(Barang $barang): View
    {
        $barang->load(['kategori', 'ruangan', 'barangMasuks', 'barangKeluars']);
        
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        
        return view('barang.edit', compact('barang', 'kategoris', 'ruangans'));
    }

    public function update(Request $request, Barang $barang): RedirectResponse
    {
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'ruangan_id' => ['required', 'exists:ruangans,id'],
        ], [
            'nama_barang.required' => 'Nama barang tidak boleh kosong',
            'kategori_id.required' => 'Kategori harus dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'ruangan_id.required' => 'Ruangan harus dipilih',
            'ruangan_id.exists' => 'Ruangan tidak valid',
        ]);

        $barang->update($validated);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang): RedirectResponse
    {
        // Check if has transactions
        if ($barang->barangMasuks()->exists() || $barang->barangKeluars()->exists()) {
            return redirect()
                ->route('barang.index')
                ->with('error', 'Tidak dapat menghapus barang yang memiliki riwayat transaksi!');
        }

        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}