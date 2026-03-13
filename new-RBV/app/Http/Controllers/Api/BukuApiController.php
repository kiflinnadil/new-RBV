<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuApiController extends Controller
{

    public function index()
    {
        return response()->json(Buku::latest()->get());
    }

    public function show($id)
    {
        return response()->json(Buku::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'=>'required',
            'penulis'=>'required',
            'tahun'=>'required',
            'deskripsi'=>'required',
            'file_pdf'=>'required|file|mimes:pdf',
            'cover'=>'required|image'
        ]);

        $pdf = $request->file('file_pdf')->store('books','public');
        $cover = $request->file('cover')->store('covers','public');

        $book = Buku::create([
            'judul'=>$request->judul,
            'penulis'=>$request->penulis,
            'tahun'=>$request->tahun,
            'deskripsi'=>$request->deskripsi,
            'file_pdf'=>$pdf,
            'cover'=>$cover
        ]);

        return response()->json($book,201);
    }

    public function update(Request $request,$id)
    {
        $book = Buku::findOrFail($id);

        $book->update($request->all());

        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Buku::findOrFail($id);

        Storage::disk('public')->delete($book->file_pdf);
        Storage::disk('public')->delete($book->cover);

        $book->delete();

        return response()->json(['message'=>'deleted']);
    }
}