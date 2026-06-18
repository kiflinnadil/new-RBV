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
            'deskripsi' => 'nullable',
            'cover'     => 'required|file|max:20480',
            'file_pdf'  => 'required|file|max:20480'
        ]);

        $cover = $request->file('cover')->store('artikel', (config('filesystems.default')));
        $pdf   = $request->file('file_pdf')->store('artikel', (config('filesystems.default')));

        Artikel::create([
            'judul'     => $request->judul,
            'tanggal'   => now(),
            'deskripsi' => $request->deskripsi,
            'cover'     => $cover,
            'file_pdf'  => $pdf
        ]);

        return redirect()->route('artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan');
    }

    public function read($id)
    {
        $artikel = Artikel::findOrFail($id);

        return redirect(
            Storage::disk(config((config('filesystems.default'))))->url($artikel->file_pdf)
        );
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('pages.Artikel.editartikel', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $data = [
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi
        ];

        if ($request->file('cover')) {
            Storage::disk((config('filesystems.default')))->delete($artikel->cover);

            $data['cover'] = $request->file('cover')
                ->store('artikel', (config('filesystems.default')));
        }

        if ($request->file('file_pdf')) {
            Storage::disk((config('filesystems.default')))->delete($artikel->file_pdf);

            $data['file_pdf'] = $request->file('file_pdf')
                ->store('artikel', (config('filesystems.default')));
        }

        $artikel->update($data);

        return redirect()->route('artikel.index')
            ->with('success', 'Artikel berhasil diupdate');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        Storage::disk((config('filesystems.default')))->delete($artikel->cover);
        Storage::disk((config('filesystems.default')))->delete($artikel->file_pdf);

        $artikel->delete();

        return redirect()->route('artikel.index')
            ->with('success', 'Artikel berhasil dihapus');
    }
}