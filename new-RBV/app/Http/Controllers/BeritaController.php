<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function berita()
    {
        $videoberita = [
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

        return view('pages.Berita.berita', compact('videoberita'));
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Berita $berita)
    {
        //
    }

    public function edit(Berita $berita)
    {
        //
    }

    public function update(Request $request, Berita $berita)
    {
        //
    }

    public function destroy(Berita $berita)
    {
        //
    }
}
