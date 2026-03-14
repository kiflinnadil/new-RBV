<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelApiController extends Controller
{
    public function index()
    {
        return response()->json(Artikel::latest()->get());
    }

    public function show($id)
    {
        return response()->json(Artikel::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'=>'required',
            'deskripsi'=>'required'
        ]);

        $artikel = Artikel::create([
            'judul'=>$request->judul,
            'tanggal'=>now(),
            'deskripsi'=>$request->deskripsi
        ]);

        return response()->json($artikel,201);
    }

    public function update(Request $request,$id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update($request->all());

        return response()->json($artikel);
    }

    public function destroy($id)
    {
        Artikel::findOrFail($id)->delete();

        return response()->json([
            'message'=>'deleted'
        ]);
    }
}