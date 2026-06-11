<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoApiController extends Controller
{
    public function index()
    {
        return response()->json(Video::latest()->get());
    }

    public function show($id)
    {
        return response()->json(Video::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'=>'required',
            'deskripsi'=>'nullable',
            'file_url'=>'required|url'
        ]);

        $video = Video::create([
            'judul'=>$request->judul,
            'tanggal'=>now(),
            'deskripsi'=>$request->deskripsi,
            'file_url'=>$request->file_url
        ]);

        return response()->json($video,201);
    }

    public function update(Request $request,$id)
    {
        $video = Video::findOrFail($id);

        $video->update($request->all());

        return response()->json($video);
    }

    public function destroy($id)
    {
        Video::findOrFail($id)->delete();

        return response()->json([
            'message'=>'deleted'
        ]);
    }
}