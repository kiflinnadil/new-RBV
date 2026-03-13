<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('pages.Video.video', compact('videos'));
    }

    public function create()
    {
        return view('pages.Video.createvideo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required|url'
        ]);

        Video::create([
            'judul' => $request->judul,
            'tanggal' => now(),
            'deskripsi' => $request->deskripsi,
            'file_url' => $request->link
        ]);

        return redirect()->route('video.index')
            ->with('success', 'Video berhasil ditambah');
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        return view('pages.Video.detailvideo', compact('video'));
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('pages.Video.editvideo', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required|url'
        ]);

        $video = Video::findOrFail($id);

        $video->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_url' => $request->link
        ]);

        return redirect()->route('video.index')
            ->with('success', 'Video berhasil diupdate');
    }

    public function destroy($id)
    {
        Video::findOrFail($id)->delete();

        return redirect()->route('video.index')
            ->with('success', 'Video berhasil dihapus');
    }
}