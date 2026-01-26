<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ruangan;

class ruanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangan = Ruangan::all();
        return view('ruangan.index', compact('ruangan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ruangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required',
            'lokasi' => 'required',
        ]  
        , [
            'nama_ruangan.required' => 'Ruangan tidak boleh kosong',
            'lokasi.required' => 'Lokasi tidak boleh kosong',
        ]
    
    );

        $ruangan = new ruangan;
        $ruangan->nama_ruangan = $request->nama_ruangan;
        $ruangan->lokasi = $request->lokasi;
        $ruangan->save();

        return redirect()->route('ruangan.index')->with('success','Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ruangan = ruangan::findOrfail($id);
        return view('ruangan.show', compact('ruangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ruangan = ruangan::findOrfail($id);
        return view('ruangan.edit', compact('ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ruangan = ruangan::findOrfail($id);
        $ruangan-> nama_ruangan = $request-> nama_ruangan;
        $ruangan-> lokasi = $request-> lokasi;
        $ruangan->save();

        return redirect()->route('ruangan.index')->with('success','Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ruangan = ruangan::findOrfail($id);
        $ruangan->delete();
        return redirect()->route('ruangan.index')->with('success', 'Data Berhasil Dihapus');
    }
}
