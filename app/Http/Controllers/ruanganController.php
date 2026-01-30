<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RuanganController extends Controller
{
    public function index(): View
    {
        $ruangans = Ruangan::withCount('users')
            ->latest()
            ->paginate(10);
            
        return view('ruangan.index', compact('ruangans'));
    }

    public function create(): View
    {
        return view('ruangan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:255', 'unique:ruangans'],
            'lokasi' => ['required', 'string', 'max:255'],
        ], [
            'nama_ruangan.required' => 'Nama ruangan tidak boleh kosong',
            'nama_ruangan.unique' => 'Nama ruangan sudah digunakan',
            'lokasi.required' => 'Lokasi tidak boleh kosong',
        ]);

        Ruangan::create($validated);

        return redirect()
            ->route('ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function show(Ruangan $ruangan): View
    {
        $ruangan->loadCount('users');
        
        return view('ruangan.show', compact('ruangan'));
    }

    public function edit(Ruangan $ruangan): View
    {
        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan): RedirectResponse
    {
        $validated = $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:255', 'unique:ruangans,nama_ruangan,' . $ruangan->id],
            'lokasi' => ['required', 'string', 'max:255'],
        ], [
            'nama_ruangan.required' => 'Nama ruangan tidak boleh kosong',
            'nama_ruangan.unique' => 'Nama ruangan sudah digunakan',
            'lokasi.required' => 'Lokasi tidak boleh kosong',
        ]);

        $ruangan->update($validated);

        return redirect()
            ->route('ruangan.index')
            ->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy(Ruangan $ruangan): RedirectResponse
    {
        if ($ruangan->users()->exists()) {
            return redirect()
                ->route('ruangan.index')
                ->with('error', 'Tidak dapat menghapus ruangan yang masih memiliki user!');
        }

        $ruangan->delete();

        return redirect()
            ->route('ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus!');
    }
}