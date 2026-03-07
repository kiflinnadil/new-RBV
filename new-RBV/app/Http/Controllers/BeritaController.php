<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function berita(Request $request)
    {
        $kategori = $request->get('kategori');
        $kategoris = ['Kesehatan', 'Teknologi', 'Pendidikan', 'Lingkungan', 'Kegiatan', 'Inovasi'];

        $all_video = [
            (object) [
                'id' => '1',
                'judul' => 'Cara Menjaga Kesehatan di Era Modern',
                'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas tips dan trik untuk menjaga kesehatan di era modern',
                'kategori' => 'Kesehatan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '2',
                'judul' => 'Teknologi Terbaru di Tahun 2025',
                'link' => 'https://www.youtube.com/embed/3JluqTojuME',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas teknologi terbaru yang akan hadir di tahun 2025',
                'kategori' => 'Teknologi',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '3',
                'judul' => 'Pentingnya Pendidikan Karakter',
                'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas pentingnya pendidikan karakter untuk generasi muda',
                'kategori' => 'Pendidikan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '4',
                'judul' => 'Dampak Perubahan Iklim Global',
                'link' => 'https://www.youtube.com/embed/3JluqTojuME',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas dampak perubahan iklim global dan upaya yang dapat dilakukan untuk mengatasinya',
                'kategori' => 'Lingkungan',
                'cover' => 'cover.png',
            ],
        ];

        if ($kategori) {
            $videoberita = array_filter($all_video, function ($v) use ($kategori) {
                return $v->kategori == $kategori;
            });
        } else {
            $videoberita = $all_video;
        }

        return view('pages.Berita.berita', compact('videoberita', 'kategori', 'kategoris'));
    }

    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        $kategoris = ['Kesehatan', 'Kegiatan', 'Inovasi'];

        $videoberita = VideoBerita::when($kategori, function ($query, $kategori) {
            return $query->where('kategori', $kategori);
        })->get();

        return view('pages.berita.index', compact('videoberita', 'kategori', 'kategoris'));
    }

    public function create()
    {
        return view('pages.Berita.createberita');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'link' => 'required|url',
        ]);

        //  Database
        /*
        VideoBerita::create([
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'link'      => $request->link,
            'tanggal'   => now(), // Menambah tanggal otomatis
        ]);
        */
        return redirect()->route('berita.berita')->with('success', 'Berita berhasil diunggah!');
    }

    public function show($id)
    {
        $all_video = [
            (object) [
                'id' => '1',
                'judul' => 'Cara Menjaga Kesehatan di Era Modern',
                'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas tips dan trik untuk menjaga kesehatan di era modern secara mendalam.',
                'kategori' => 'Kesehatan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '2',
                'judul' => 'Teknologi Terbaru di Tahun 2025',
                'link' => 'https://www.youtube.com/embed/3JluqTojuME',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas teknologi terbaru yang akan hadir di tahun 2025 dan dampaknya bagi kita.',
                'kategori' => 'Teknologi',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '3',
                'judul' => 'Pentingnya Pendidikan Karakter',
                'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas pentingnya pendidikan karakter untuk generasi muda di masa depan.',
                'kategori' => 'Pendidikan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '4',
                'judul' => 'Dampak Perubahan Iklim Global',
                'link' => 'https://www.youtube.com/embed/3JluqTojuME',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas dampak perubahan iklim global dan upaya nyata yang dapat dilakukan.',
                'kategori' => 'Lingkungan',
                'cover' => 'cover.png',
            ],
        ];

        $video = collect($all_video)->where('id', $id)->first();

        if (! $video) {
            abort(404);
        }

        return view('pages.Berita.show', compact('video'));
    }

    public function edit(Berita $berita)
    {
        $video = (object) [
            'id' => $berita->id,
            'judul' => $berita->judul,
            'link' => $berita->link,
            'tanggal' => $berita->tanggal,
            'deskripsi' => $berita->deskripsi,
            'kategori' => $berita->kategori,
        ];

        return view('pages.Berita.editberita', compact('video'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'link' => 'required|url',
        ]);

        // Update Database
        /*
        $berita->update([
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'link'      => $request->link,
        ]);
        */

        return redirect()->route('berita.berita')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Berita $berita)
    {
        //
    }
}
