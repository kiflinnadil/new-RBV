<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Panduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanduanApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Panduan::query();

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $panduans = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $panduans
        ]);
    }

    public function show($id)
    {
        $panduan = Panduan::find($id);

        if (!$panduan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $panduan
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:20480',
        ]);

        $file = $request->file('file')->store('panduan', 'public');

        $panduan = Panduan::create([
            'judul' => $request->judul,
            'file' => $file,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ditambahkan',
            'data' => $panduan
        ]);
    }

    public function update(Request $request, $id)
    {
        $panduan = Panduan::find($id);

        if (!$panduan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $data = [
            'judul' => $request->judul,
        ];

        if ($request->file('file')) {
            Storage::disk('public')->delete($panduan->file);
            $data['file'] = $request->file('file')->store('panduan', 'public');
        }

        $panduan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil diupdate',
            'data' => $panduan
        ]);
    }

    public function destroy($id)
    {
        $panduan = Panduan::find($id);

        if (!$panduan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        Storage::disk('public')->delete($panduan->file);
        $panduan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil dihapus'
        ]);
    }
}