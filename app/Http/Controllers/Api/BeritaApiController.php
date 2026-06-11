<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaApiController extends Controller
{
    public function index()
    {
        return response()->json(Berita::latest()->get());
    }

    public function show($id)
    {
        return response()->json(Berita::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'=>'required',
            'kategori'=>'required',
            'deskripsi'=>'nullable',
            'file_url'=>'required|url',
            'cover'=>'required|image|max:20480'
        ]);

        $cover = $request->file('cover')->store('berita','public');

        $berita = Berita::create([
            'judul'=>$request->judul,
            'kategori'=>$request->kategori,
            'tanggal'=>now(),
            'deskripsi'=>$request->deskripsi,
            'file_url'=>$request->file_url,
            'cover'=>$cover
        ]);

        return response()->json($berita,201);
    }

    public function update(Request $request,$id)
    {
        $berita = Berita::findOrFail($id);

        $data = [
            'judul'=>$request->judul,
            'kategori'=>$request->kategori,
            'deskripsi'=>$request->deskripsi,
            'file_url'=>$request->file_url
        ];

        if($request->file('cover')){
            Storage::disk('public')->delete($berita->cover);
            $data['cover'] = $request->file('cover')->store('berita','public');
        }

        $berita->update($data);

        return response()->json($berita);
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        Storage::disk('public')->delete($berita->cover);
        $berita->delete();

        return response()->json([
            'message'=>'deleted'
        ]);
    }
}