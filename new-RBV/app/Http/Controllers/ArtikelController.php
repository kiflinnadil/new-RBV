<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return view('pages.Artikel.artikel', compact('artikels'));
    }

    public function create()
    {
        return view('pages.Artikel.createartikel');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required',
            'deskripsi' => 'required',
            'cover'     => 'required|file|max:20480',
            'file_pdf'  => 'required|file|mimes:pdf|max:20480'
        ]);

        $cover = $request->file('cover')->store('artikel','public');
        $pdf   = $request->file('file_pdf')->store('artikel','public');

        Artikel::create([
            'judul'     => $request->judul,
            'tanggal'   => now(),
            'deskripsi' => $request->deskripsi,
            'cover'     => $cover,
            'file_pdf'  => $pdf
        ]);

        return redirect()->route('artikel.index')
            ->with('success','Artikel berhasil ditambahkan');
    }

    public function read($id)
    {
        $artikel = Artikel::findOrFail($id);

        return response()->file(
            storage_path('app/public/' . $artikel->file_pdf),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="artikel.pdf"'
            ]
        );
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('pages.Artikel.editartikel', compact('artikel'));
    }

    public function update(Request $request,$id)
    {
        $artikel = Artikel::findOrFail($id);

        $data = [
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi
        ];

        if($request->file('cover')){
            Storage::disk('public')->delete($artikel->cover);
            $data['cover'] = $request->file('cover')->store('artikel','public');
        }

        if($request->file('file_pdf')){
            Storage::disk('public')->delete($artikel->file_pdf);
            $data['file_pdf'] = $request->file('file_pdf')->store('artikel','public');
        }

        $artikel->update($data);

        return redirect()->route('artikel.index')
            ->with('success','Artikel berhasil diupdate');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        Storage::disk('public')->delete($artikel->cover);
        Storage::disk('public')->delete($artikel->file_pdf);

        $artikel->delete();

        return redirect()->route('artikel.index')
            ->with('success','Artikel berhasil dihapus');
    }
}