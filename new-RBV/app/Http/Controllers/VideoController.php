<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = [
            (object) [
                'id' => 1,
                'judul' => 'Belajar Laravel',
                'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video tutorial belajar Laravel untuk pemula.',
            ],
            (object) [
                'id' => 2,
                'judul' => 'Belajar JavaScript',
                'link' => 'https://www.youtube.com/embed/3JluqTojuME',
                'tanggal' => '2025-09-01',
                'deskripsi' => 'Video tutorial belajar JavaScript untuk pemula.',
            ],
        ];

        return view('pages.Video.video', compact('videos'));
    }

    public function show($id)
    {
        $videos = (object) [
            [
                'id' => $id,
                'judul' => 'Belajar Laravel'.$id,
                'link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'.$id,
                'tanggal' => '2025-09-01'.$id,
                'deskripsi' => 'Video tutorial belajar Laravel untuk pemula.'.$id,
            ],
        ];

        return view('pages.Video.detailvideo', compact('videos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    // public function show(Video $video)
    // {
    //     return view('pages.Video.detailvideo', compact('video'));
    // }

    public function edit(Video $video)
    {
        //
    }

    public function update(Request $request, Video $video)
    {
        //
    }

    public function destroy(Video $video)
    {
        //
    }
}
