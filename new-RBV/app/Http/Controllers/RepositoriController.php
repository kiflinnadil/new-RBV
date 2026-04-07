<?php

namespace App\Http\Controllers;

use App\Models\Repositori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepositoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Repositori::query();

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $repositoris = $query->latest()->paginate(10);

        $kategoris = [];
        $kategori = null;

        return view('pages.Layanan.repositori.repositori', compact('repositoris', 'kategoris', 'kategori'));
    }

    public function create()
    {
        return view('pages.Layanan.repositori.repositoricreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'file' => 'required|file|mimes:pdf|max:20480',
        ]);

        $path = $request->file('file')->store('repositori', 'public');

        Repositori::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $path
        ]);

        return redirect()->route('repositori.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $repositori = Repositori::findOrFail($id);

        return view('pages.Layanan.repositori.repositoriedit', compact('repositori'));
    }

    public function update(Request $request, $id)
    {
        $repositori = Repositori::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ];

        if ($request->file('file')) {
            Storage::disk('public')->delete($repositori->file);
            $data['file'] = $request->file('file')->store('repositori', 'public');
        }

        $repositori->update($data);

        return redirect()->route('repositori.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $repositori = Repositori::findOrFail($id);

        Storage::disk('public')->delete($repositori->file);
        $repositori->delete();

        return redirect()->route('repositori.index')
            ->with('success', 'Data berhasil dihapus');
    }
}