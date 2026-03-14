<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function beranda()
    {
        $books = Buku::latest()->take(5)->get();

        $labels = ['2025-09', '2025-10', '2025-11', '2025-12', '2026-01'];
        $dataKunjungan = [25, 130, 365, 20, 110];

        return view('pages.beranda', compact('books','labels','dataKunjungan'));
    }

    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('penulis', 'like', '%' . $request->search . '%')
                ->orWhere('kategori', 'like', '%' . $request->search . '%');
            });
        }

        $books = $query->latest()->get();

        return view('pages.DaftarBuku.daftarbuku', compact('books'));
    }

    public function show($id)
    {
        $book = Buku::findOrFail($id);
        return view('pages.DaftarBuku.detaildaftarbuku', compact('book'));
    }

    public function read($id)
    {
        $buku = Buku::findOrFail($id);
        return response()->file(storage_path('app/public/'.$buku->file_pdf));
    }
    public function create()
    {
        return view('pages.DaftarBuku.createbuku');
    }

    public function store(Request $request)
{
    $request->validate([
        'judul'=>'required',
        'pengarang'=>'required',
        'kategori'=>'required',
        'tahun_terbit'=>'required',
        'deskripsi'=>'required',
        'file_pdf'=>'required|file|mimes:pdf|max:20480',
        'cover'=>'required|file|max:20480'
    ]);

    $pdf = $request->file('file_pdf')->store('books','public');
    $cover = $request->file('cover')->store('covers','public');

    Buku::create([
        'judul'=>$request->judul,
        'penulis'=>$request->pengarang,
        'kategori'=>$request->kategori,
        'tahun'=>$request->tahun_terbit,
        'deskripsi'=>$request->deskripsi,
        'file_pdf'=>$pdf,
        'cover'=>$cover
    ]);

    return redirect()->route('books.index')->with('success','Buku berhasil ditambahkan');
}

    public function edit($id)
    {
        $book = Buku::findOrFail($id);
        return view('pages.DaftarBuku.editbuku', compact('book'));
    }

    public function update(Request $request,$id)
    {
        $buku = Buku::findOrFail($id);

        $data = [
            'judul'=>$request->judul,
            'penulis'=>$request->pengarang,
            'kategori'=>$request->kategori,
            'tahun'=>$request->tahun_terbit,
            'deskripsi'=>$request->deskripsi
        ];

        if($request->file('file_pdf')){
            Storage::disk('public')->delete($buku->file_pdf);
            $data['file_pdf'] = $request->file('file_pdf')->store('books','public');
        }

        if($request->file('cover')){
            Storage::disk('public')->delete($buku->cover);
            $data['cover'] = $request->file('cover')->store('covers','public');
        }

        $buku->update($data);

        return redirect()->route('books.index')->with('success','Buku berhasil diupdate');
    }

    public function destroy($id)
    {
        $book = Buku::findOrFail($id);

        Storage::disk('public')->delete($book->file_pdf);
        Storage::disk('public')->delete($book->cover);

        $book->delete();

        return redirect()->route('books.index')->with('success','Buku berhasil dihapus');
    }
}