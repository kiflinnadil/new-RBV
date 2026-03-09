<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = collect([
            (object) [
                'id' => 1,
                'judul' => 'Lowongan Kerja Sekretaris',
                'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'tanggal' => '2026-02-02',
                'kategori' => 'Kesehatan',
                'deskripsi' => 'Deskripsi isi berita ini adalah bla blabalba lalbalbalblaa.',
            ],
            (object) [
                'id' => 2,
                'judul' => 'Tips Menjaga Kesehatan Jantung',
                'link' => 'https://www.youtube.com/embed/3JluqTojuME',
                'tanggal' => '2026-03-01',
                'kategori' => 'Edukasi',
                'deskripsi' => 'Edukasi mengenai pentingnya menjaga pola makan dan olahraga rutin.',
            ],
            (object) [
                'id' => 3,
                'judul' => 'Prosedur Layanan IGD',
                'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'tanggal' => '2026-03-05',
                'kategori' => 'Layanan',
                'deskripsi' => 'Informasi mengenai alur penanganan pasien gawat darurat.',
            ],
        ]);

        return view('pages.Video.video', compact('videos'));
    }

    public function create()
    {
        return view('pages.Video.createvideo');
    }

    public function store(Request $request)
    {
        return redirect()->route('video.index')->with('success', 'Video berhasil ditambah!');
    }

    public function show($id)
    {
        $videos = $this->getRawData();
        $video = $videos->firstWhere('id', (int) $id);

        if (! $video) {
            abort(404);
        }

        return view('pages.Video.detailvideo', compact('video'));
    }

    public function edit($id)
    {
        $videos = $this->getRawData();
        $video = $videos->firstWhere('id', (int) $id);

        if (! $video) {
            abort(404);
        }

        return view('pages.Video.editvideo', compact('video'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('video.index')->with('success', 'Video diperbarui!');
    }

    public function destroy($id)
    {
        return redirect()->route('video.index')->with('success', 'Video dihapus!');
    }

    private function getRawData()
    {
        return collect([
            (object) ['id' => 1, 'judul' => 'Lowongan Kerja Sekretaris', 'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'tanggal' => '2026-02-02', 'deskripsi' => 'Deskripsi isi berita.'],
            (object) ['id' => 2, 'judul' => 'Tips Menjaga Kesehatan Jantung', 'link' => 'https://www.youtube.com/embed/3JluqTojuME', 'tanggal' => '2026-03-01', 'deskripsi' => 'Edukasi kesehatan.'],
            (object) ['id' => 3, 'judul' => 'Prosedur Layanan IGD', 'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'tanggal' => '2026-03-05', 'deskripsi' => 'Informasi layanan.'],
        ]);
    }
}
