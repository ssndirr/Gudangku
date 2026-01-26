<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $ruangan  = Ruangan::all();
        return view('barang.create', compact('kategori','ruangan'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'nama_barang' => 'required',
        'kategori_id' => 'required',
        'ruangan_id'  => 'required',
    ]);

    Barang::create([
        'nama_barang' => $request->nama_barang,
        'kategori_id' => $request->kategori_id,
        'ruangan_id'  => $request->ruangan_id,
        'stok'        => 0, // otomatis 0
    ]);

    return redirect()->route('barang.index')
        ->with('success','Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $barang   = Barang::findOrFail($id);
        $kategori = Kategori::all();
        $ruangan  = Ruangan::all();

        return view('barang.edit', compact('barang','kategori','ruangan'));
    }
    
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();
        return view('barang.show', compact('barang','kategori','ruangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori_id' => 'required',
            'ruangan_id'  => 'required',
            'stok'        => 'required|integer|min:0', 
        ]);

        $barang = Barang::findOrFail($id);

        // pastikan stok tidak dikurangi di update
        if ($request->stok < $barang->stok) {
            return redirect()->back()->with('error', 'Stok tidak boleh dikurangi secara manual');
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'ruangan_id'  => $request->ruangan_id,
            'stok'        => $request->stok,
        ]);

        return redirect()->route('barang.index')
            ->with('success','Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();

        return redirect()->route('barang.index')
            ->with('success','Data Berhasil Dihapus');
    }
}
