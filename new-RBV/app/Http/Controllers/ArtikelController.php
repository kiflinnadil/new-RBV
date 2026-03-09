<?php

namespace App\Http\Controllers;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = [
            (object) [
                'id' => '1',
                'judul' => 'Kesehatan',
                'deskripsi' => 'lorem ipsum',
                'cover' => 'cover.png',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=sharing',
            ],

            (object) [
                'id' => '2',
                'judul' => 'Lorem',
                'deskripsi' => 'lorem ipsum',
                'cover' => 'cover.png',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=sharing',
            ],

        ];

        return view('pages.Artikel.artikel', compact('artikels'));
    }

    public function create()
    {
        return view('pages.Artikel.createartikel');
    }

    public function show($id)
    {
        $artikel = (object) [
            'id' => $id,
            'judul' => 'kesehatan'.$id,
            'deskripsi' => 'Lorem Ipsum'.$id,
            'cover' => 'cover.png'.$id,
            'file_pdf' => 'path/to/file'.$id.'.pdf',
        ];

        return view('pages.Artikel.detailartikel', compact('artikel'));
    }

    public function edit($id)
    {
        $all_artikel = [
            (object) [
                'id' => '1',
                'judul' => 'Cara Menjaga Kesehatan di Era Modern',
                'deskripsi' => 'Video ini membahas tips dan trik untuk menjaga kesehatan di era modern secara mendalam.',
                'cover' => 'cover.png',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=sharing',
            ],
            (object) [
                'id' => '2',
                'judul' => 'Teknologi Terbaru di Tahun 2025',
                'deskripsi' => 'Video ini membahas teknologi terbaru yang akan hadir di tahun 2025 dan dampaknya bagi kita.',
                'cover' => 'cover.png',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=sharing',
            ],
            (object) [
                'id' => '3',
                'judul' => 'Pentingnya Pendidikan Karakter',
                'deskripsi' => 'Video ini membahas pentingnya pendidikan karakter untuk generasi muda di masa depan.',
                'cover' => 'cover.png',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=sharing',
            ],
            (object) [
                'id' => '4',
                'judul' => 'Dampak Perubahan Iklim Global',
                'deskripsi' => 'Video ini membahas dampak perubahan iklim global dan upaya nyata yang dapat dilakukan.',
                'cover' => 'cover.png',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=sharing',
            ],
        ];

        $artikel = collect($all_artikel)->where('id', $id)->first();

        if (! $artikel) {
            abort(404);
        }

        return view('pages.Artikel.editartikel', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'file_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'cover' => 'nullable|image|max:20480',
        ]);

        $artikel = Buku::findOrFail($id);

        $artikel->judul = $request->judul;
        $buku->deskripsi = $request->deskripsi;

        if ($request->hasFile('file_pdf')) {
            $buku->file_pdf = $request->file('file_pdf')->store('artikel');
        }

        if ($request->hasFile('cover')) {
            $buku->cover = $request->file('cover')->store('covers', 'public');
        }

        $artikel->save();

        return redirect()->route('artikel.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function delete(Artikel $artikel)
    {
        $artikel = Artikel::findOrFail($id);

        if ($artikel->cover) {
            Storage::disk('public')->delete($artikel->cover);
        }
        if ($artikel->file_pdf) {
            Storage::disk('public')->delete($artikel->file_pdf);
        }

        $artikel->delete();

        return redirect()->route('artikel.index')->with('success', 'Buku berhasil dihapus!');
    }
}
