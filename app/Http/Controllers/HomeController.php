<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Ambil semua kategori untuk dropdown
        $kategoris = Kategori::all();

        $query = Barang::with(['kategori', 'ruangan']);

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter nama barang
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', "%{$request->search}%");
        }

        $barangs = $query->paginate(12);

        return view('home', compact('barangs', 'kategoris'));
    }

    public function show($id)
    {
        // Ambil data barang, tapi kita acak atributnya untuk tampilan
        $barang = Barang::with(['kategori','ruangan'])->findOrFail($id);

        // Contoh randomisasi atau custom data
        $customData = [
            'id' => $barang->id_barang,
            'nama_barang' => $barang->nama_barang,
            'kategori' => $barang->kategori->nama_kategori ?? 'Kategori Random',
            'ruangan' => $barang->ruangan->nama_ruangan ?? 'Ruangan Random',
            'alamat' => 'Jl. Contoh No. '.rand(1, 100),
            'stok' => rand(1, 50),
            'deskripsi' => 'Deskripsi barang bisa kita custom sesuka hati.'
        ];

        return view('homeshow', compact('customData'));
    }
}