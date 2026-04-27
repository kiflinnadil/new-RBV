<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            'deskripsi' => 'nullable',
            'link' => 'required|url',
        ]);

        $url = $request->link;
        $thumbnail = null;

        if (preg_match('/(youtube\.com|youtu\.be)/', $url)) {
            preg_match('/(v=|youtu\.be\/)([^\&\?\/]+)/', $url, $yt);
            $id = $yt[2] ?? null;

            if ($id) {
                $thumbnail = "https://img.youtube.com/vi/$id/hqdefault.jpg";
            }
        } elseif (preg_match('/tiktok\.com/', $url)) {
            try {
                $response = Http::get('https://www.tiktok.com/oembed?url='.$url);

                if ($response->successful()) {
                    $thumbnail = $response->json()['thumbnail_url'] ?? null;
                }
            } catch (\Exception $e) {
            }

            if (! $thumbnail) {
                $thumbnail = 'https://via.placeholder.com/400x300?text=TikTok';
            }
        } elseif (preg_match('/instagram\.com/', $url)) {
            $thumbnail = 'https://via.placeholder.com/400x300?text=Instagram';
        }

        if (! $thumbnail) {
            $thumbnail = 'https://via.placeholder.com/400x300?text=Video';
        }

        Video::create([
            'judul' => $request->judul,
            'tanggal' => now(),
            'deskripsi' => $request->deskripsi,
            'file_url' => $url,
            'thumbnail' => $thumbnail,
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
            'deskripsi' => 'nullable',
            'link' => 'required|url',
        ]);

        $video = Video::findOrFail($id);

        $video->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_url' => $request->link,
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
