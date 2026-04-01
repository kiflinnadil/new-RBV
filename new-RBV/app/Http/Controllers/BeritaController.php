<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    private function checkRole()
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['super_admin','admin'])) {
            abort(403, 'Akses ditolak');
        }
    }

    public function index(Request $request)
    {
        $kategori = $request->get('kategori');

        $kategoris = ['Kesehatan','Kegiatan','Inovasi'];

        $berita = Berita::when($kategori, function ($q) use ($kategori) {
            $q->where('kategori', $kategori);
        })->latest()->get();

        return view('pages.Berita.berita', compact('berita','kategori','kategoris'));
    }

    public function create()
    {
        $this->checkRole(); 
        return view('pages.Berita.createberita');
    }

    public function store(Request $request)
    {
        $this->checkRole();

        $request->validate([
            'judul'=>'required',
            'kategori'=>'required',
            'deskripsi'=>'nullable',
            'link'=>'required|url',
            'cover'=>'required|image|max:20480'
        ]);

        $cover = $request->file('cover')->store('berita','public');

        Berita::create([
            'judul'=>$request->judul,
            'kategori'=>$request->kategori,
            'tanggal'=>now(),
            'deskripsi'=>$request->deskripsi,
            'file_url'=>$request->link,
            'cover'=>$cover
        ]);

        return redirect()->route('berita.index')
            ->with('success','Berita berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->checkRole();

        $berita = Berita::findOrFail($id);
        return view('pages.Berita.editberita', compact('berita'));
    }

    public function update(Request $request,$id)
    {
        $this->checkRole();

        $request->validate([
            'judul'=>'required',
            'kategori'=>'required',
            'deskripsi'=>'nullable',
            'link'=>'required|url',
            'cover'=>'nullable|image|max:20480'
        ]);

        $berita = Berita::findOrFail($id);

        $data = [
            'judul'=>$request->judul,
            'kategori'=>$request->kategori,
            'deskripsi'=>$request->deskripsi,
            'file_url'=>$request->link
        ];

        if($request->file('cover')){
            Storage::disk('public')->delete($berita->cover);
            $data['cover'] = $request->file('cover')->store('berita','public');
        }

        $berita->update($data);

        return redirect()->route('berita.index')
            ->with('success','Berita berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->checkRole();

        $berita = Berita::findOrFail($id);

        Storage::disk('public')->delete($berita->cover);
        $berita->delete();

        return redirect()->route('berita.index')
            ->with('success','Berita berhasil dihapus');
    }
}