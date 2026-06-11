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

    /**
     * Ambil thumbnail dari URL video (YouTube, TikTok, Instagram)
     */
    private function getThumbnail(string $url): string
    {
        // ── YouTube ──────────────────────────────────────────────────────────
        if (preg_match('/(youtube\.com|youtu\.be)/i', $url)) {
            preg_match('/(?:v=|youtu\.be\/|embed\/|shorts\/)([a-zA-Z0-9_-]{11})/', $url, $yt);
            $id = $yt[1] ?? null;

            if ($id) {
                // Coba maxresdefault dulu, fallback ke hqdefault
                $maxres = "https://img.youtube.com/vi/{$id}/maxresdefault.jpg";
                $hq     = "https://img.youtube.com/vi/{$id}/hqdefault.jpg";

                try {
                    $check = Http::timeout(5)->head($maxres);
                    // YouTube mengembalikan 200 tapi gambar 120x90 jika tidak ada maxres
                    $thumbnail = ($check->successful() && ($check->header('Content-Length') ?? 0) > 2000)
                        ? $maxres
                        : $hq;
                } catch (\Exception $e) {
                    $thumbnail = $hq;
                }

                return $thumbnail;
            }
        }

        // ── TikTok ───────────────────────────────────────────────────────────
        if (preg_match('/tiktok\.com/i', $url)) {
            try {
                // oEmbed resmi TikTok
                $response = Http::timeout(10)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                    ->get('https://www.tiktok.com/oembed', ['url' => $url]);

                if ($response->successful()) {
                    $thumb = $response->json('thumbnail_url');
                    if ($thumb) return $thumb;
                }
            } catch (\Exception $e) {
                // lanjut ke fallback
            }

            // Fallback: coba ambil via noembed.com
            try {
                $response = Http::timeout(10)
                    ->get('https://noembed.com/embed', ['url' => $url]);

                if ($response->successful()) {
                    $thumb = $response->json('thumbnail_url');
                    if ($thumb) return $thumb;
                }
            } catch (\Exception $e) {
                // lanjut ke placeholder
            }

            return 'https://placehold.co/400x300?text=TikTok';
        }

        // ── Instagram ────────────────────────────────────────────────────────
        if (preg_match('/instagram\.com/i', $url)) {
            try {
                // oEmbed Instagram (butuh Facebook Access Token di env jika private)
                $token = config('services.instagram.token'); // opsional
                $params = ['url' => $url, 'omitscript' => true];
                if ($token) $params['access_token'] = $token;

                $response = Http::timeout(10)
                    ->get('https://graph.facebook.com/v19.0/instagram_oembed', $params);

                if ($response->successful()) {
                    $thumb = $response->json('thumbnail_url');
                    if ($thumb) return $thumb;
                }
            } catch (\Exception $e) {
                // lanjut ke fallback
            }

            return 'https://placehold.co/400x300?text=Instagram';
        }

        // ── Fallback umum ────────────────────────────────────────────────────
        return 'https://placehold.co/400x300?text=Video';
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required',
            'deskripsi'=> 'nullable',
            'link'     => 'required|url',
        ]);

        Video::create([
            'judul'    => $request->judul,
            'tanggal'  => now(),
            'deskripsi'=> $request->deskripsi,
            'file_url' => $request->link,
            'thumbnail'=> $this->getThumbnail($request->link),
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
            'judul'    => 'required',
            'deskripsi'=> 'nullable',
            'link'     => 'required|url',
        ]);

        $video = Video::findOrFail($id);
        $video->update([
            'judul'    => $request->judul,
            'deskripsi'=> $request->deskripsi,
            'file_url' => $request->link,
            'thumbnail'=> $this->getThumbnail($request->link),  // update thumbnail juga
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