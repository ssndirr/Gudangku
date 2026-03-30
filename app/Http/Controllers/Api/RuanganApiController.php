<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Ruangan::withCount(['users', 'barangs'])
                ->latest()
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangans',
            'lokasi' => 'required|string|max:255',
        ]);

        $ruangan = Ruangan::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Ruangan berhasil ditambahkan',
            'data' => $ruangan
        ], 201);
    }

    public function show($id)
    {
        $ruangan = Ruangan::withCount(['users', 'barangs'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $ruangan
        ]);
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangans,nama_ruangan,' . $ruangan->id,
            'lokasi' => 'required|string|max:255',
        ]);

        $ruangan->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Ruangan berhasil diperbarui',
            'data' => $ruangan
        ]);
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        if ($ruangan->users()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Ruangan masih memiliki user'
            ], 409);
        }

        $ruangan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Ruangan berhasil dihapus'
        ]);
    }
}
