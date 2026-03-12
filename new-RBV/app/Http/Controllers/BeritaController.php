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
                'link' => 'https://health.detik.com/',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas tips dan trik untuk menjaga kesehatan di era modern',
                'kategori' => 'Kesehatan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '2',
                'judul' => 'Teknologi Terbaru di Tahun 2025',
                'link' => 'https://tekno.kompas.com/',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas teknologi terbaru yang akan hadir di tahun 2025',
                'kategori' => 'Teknologi',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '3',
                'judul' => 'Pentingnya Pendidikan Karakter',
                'link' => 'https://www.kemendikdasmen.go.id/berita/13655-pendidikan-bermutu-dimulai-dari-pendidikan-karakter-sejak-di',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas pentingnya pendidikan karakter untuk generasi muda',
                'kategori' => 'Pendidikan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '4',
                'judul' => 'Dampak Perubahan Iklim Global',
                'link' => 'https://www.detik.com/tag/lingkungan',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas dampak perubahan iklim global dan upaya yang dapat dilakukan untuk mengatasinya',
                'kategori' => 'Lingkungan',
                'cover' => 'cover.png',
            ],
        ];

        if ($kategori) {
            $berita = array_filter($all_video, function ($v) use ($kategori) {
                return $v->kategori == $kategori;
            });
        } else {
            $berita = $all_video;
        }

        return view('pages.Berita.berita', compact('berita', 'kategori', 'kategoris'));
    }

    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        $kategoris = ['Kesehatan', 'Kegiatan', 'Inovasi'];

        $berita = berita::when($kategori, function ($query, $kategori) {
            return $query->where('kategori', $kategori);
        })->get();

        return view('pages.berita.index', compact('berita', 'kategori', 'kategoris'));
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
                'link' => 'https://health.detik.com/',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas tips dan trik untuk menjaga kesehatan di era modern secara mendalam.',
                'kategori' => 'Kesehatan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '2',
                'judul' => 'Teknologi Terbaru di Tahun 2025',
                'link' => 'https://tekno.kompas.com/',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas teknologi terbaru yang akan hadir di tahun 2025 dan dampaknya bagi kita.',
                'kategori' => 'Teknologi',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '3',
                'judul' => 'Pentingnya Pendidikan Karakter',
                'link' => 'https://www.kemendikdasmen.go.id/berita/13655-pendidikan-bermutu-dimulai-dari-pendidikan-karakter-sejak-di',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas pentingnya pendidikan karakter untuk generasi muda di masa depan.',
                'kategori' => 'Pendidikan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '4',
                'judul' => 'Dampak Perubahan Iklim Global',
                'link' => 'https://www.detik.com/tag/lingkungan',
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

    public function edit($id)
    {
        $all_video = [
            (object) [
                'id' => '1',
                'judul' => 'Cara Menjaga Kesehatan di Era Modern',
                'link' => 'https://health.detik.com/',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas tips dan trik untuk menjaga kesehatan di era modern secara mendalam.',
                'kategori' => 'Kesehatan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '2',
                'judul' => 'Teknologi Terbaru di Tahun 2025',
                'link' => 'https://tekno.kompas.com/',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas teknologi terbaru yang akan hadir di tahun 2025 dan dampaknya bagi kita.',
                'kategori' => 'Teknologi',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '3',
                'judul' => 'Pentingnya Pendidikan Karakter',
                'link' => 'https://www.kemendikdasmen.go.id/berita/13655-pendidikan-bermutu-dimulai-dari-pendidikan-karakter-sejak-di',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas pentingnya pendidikan karakter untuk generasi muda di masa depan.',
                'kategori' => 'Pendidikan',
                'cover' => 'cover.png',
            ],
            (object) [
                'id' => '4',
                'judul' => 'Dampak Perubahan Iklim Global',
                'link' => 'https://www.detik.com/tag/lingkungan',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video ini membahas dampak perubahan iklim global dan upaya nyata yang dapat dilakukan.',
                'kategori' => 'Lingkungan',
                'cover' => 'cover.png',
            ],
        ];

        $berita = collect($all_video)->where('id', $id)->first();

        if (! $berita) {
            abort(404);
        }

        return view('pages.Berita.editberita', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'link' => 'required|url',
        ]);

        $berita = Buku::findOrFail($id);

        $berita->judul = $request->judul;
        $berita->kategori = $request->kategori;
        $berita->deskripsi = $request->deskripsi;
        $berita->link = $request->link;

        if ($request->hasFile('file_buku')) {
            $berita->file_pdf = $request->file('file_buku')->store('books', 'public');
        }

        if ($request->hasFile('cover')) {
            $berita->cover = $request->file('cover')->store('covers', 'public');
        }

        $berita->save();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui!');

    }

    public function destroy(Berita $berita)
    {
        return redirect()->back()->with('success', 'Berita berhasil dihapus!');
    }
}
