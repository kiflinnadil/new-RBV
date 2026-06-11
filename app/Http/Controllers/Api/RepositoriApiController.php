<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Repositori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepositoriApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Repositori::latest()->get()
        );
    }

    public function show($id)
    {
        return response()->json(
            Repositori::findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'file' => 'required|file|mimes:pdf'
        ]);

        $path = $request->file('file')->store('repositori', 'public');

        $data = Repositori::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $path
        ]);

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $repositori = Repositori::findOrFail($id);

        $data = $request->only(['judul', 'deskripsi']);

        if ($request->file('file')) {
            Storage::disk('public')->delete($repositori->file);
            $data['file'] = $request->file('file')->store('repositori', 'public');
        }

        $repositori->update($data);

        return response()->json($repositori);
    }

    public function destroy($id)
    {
        $repositori = Repositori::findOrFail($id);

        Storage::disk('public')->delete($repositori->file);
        $repositori->delete();

        return response()->json(['message' => 'deleted']);
    }
}