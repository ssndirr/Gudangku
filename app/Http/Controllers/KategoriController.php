<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategoris = Kategori::withCount('barangs')
            ->latest()
            ->paginate(10);
            
        return view('kategori.index', compact('kategoris'));
    }

    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategoris'],
        ], [
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(Kategori $kategori): View
    {
        $kategori->loadCount('barangs');
        
        return view('kategori.show', compact('kategori'));
    }

    public function edit(Kategori $kategori): View
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategoris,nama_kategori,' . $kategori->id],
        ], [
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        if ($kategori->barangs()->exists()) {
            return redirect()
                ->route('kategori.index')
                ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki barang!');
        }

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}