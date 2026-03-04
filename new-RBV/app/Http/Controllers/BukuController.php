<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function beranda()
    {
        // $books = Buku::latest()->take(3)->get();
        // $books = Buku::orderBy('id_buku', 'desc')->take(3)->get();
        $books = [
            (object) [
                'id_buku' => 1,
                'judul' => 'Filosofi Teras',
                'penulis' => 'Pengarang 1',
                'tahun' => 2020,
                'kategori' => 'Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'Deskripsi buku 1',
            ],
            (object) [
                'id_buku' => 2,
                'judul' => 'Mens from Mars, Women from Venus',
                'penulis' => 'Pengarang 2',
                'tahun' => 2021,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'Deskripsi buku 2',
            ],
            (object) [
                'id_buku' => 3,
                'judul' => 'Makanya Mikir',
                'penulis' => 'Pengarang 3',
                'tahun' => 2022,
                'kategori' => 'Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'Deskripsi buku 3',
            ],
            (object) [
                'id_buku' => 4,
                'judul' => 'Madilog',
                'penulis' => 'Pengarang 4',
                'tahun' => 2023,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'Deskripsi buku 4',
            ],
        ];

        $labels = ['2025-09', '2025-10', '2025-11', '2025-12', '2026-01'];
        $dataKunjungan = [25, 130, 365, 20, 110];

        return view('pages.beranda', compact('books', 'labels', 'dataKunjungan'));
    }

    public function index()
    {
        $favorites = session('favorites', []);

        $books = [
            (object) [
                'id_buku' => 1,
                'judul' => 'Buku 1',
                'penulis' => 'Pengarang 1',
                'tahun' => 2020,
                'kategori' => 'Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'Deskripsi lengkap buku 1',
                'is_favorite' => in_array(1, $favorites),
            ],
            (object) [
                'id_buku' => 2,
                'judul' => 'Buku 2',
                'penulis' => 'Pengarang 2',
                'tahun' => 2021,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'Deskripsi lengkap buku 2',
                'is_favorite' => in_array(2, $favorites),
            ],
        ];

        return view('pages.DaftarBuku.daftarbuku', compact('books'));
    }

    public function show($id)
    {
        $favorites = session('favorites', []);

        $book = (object) [
            'id_buku' => $id,
            'judul' => 'Buku '.$id,
            'penulis' => 'Pengarang '.$id,
            'tahun' => 2020 + $id,
            'kategori' => 'Kategori '.$id,
            'file_pdf' => 'path/to/file'.$id.'.pdf',
            'cover' => 'images/cover'.$id.'.jpg',
            'deskripsi' => 'Deskripsi buku '.$id,
            'is_favorite' => in_array((int) $id, $favorites),
        ];

        return view('pages.DaftarBuku.detaildaftarbuku', compact('book'));
    }

    public function toggleFavorite(Request $request, $id)
    {
        $favorites = session('favorites', []);
        $id = (int) $id;

        if (in_array($id, $favorites)) {
            $favorites = array_values(array_filter($favorites, fn ($f) => $f !== $id));
        } else {
            $favorites[] = $id;
        }

        session(['favorites' => $favorites]);

        return redirect()->back();
    }

    public function read($id)
    {
        // $book = Buku::findOrFail($id);
        $book = (object) [
            'id_buku' => $id,
            'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link'.$id.'.pdf',
        ];

        return redirect($book->file_pdf);
    }

    public function favorit()
    {
        $favorites = session('favorites', []);

        $allBooks = [
            (object) ['id_buku' => 1, 'judul' => 'Buku 1', 'penulis' => 'Pengarang 1', 'tahun' => 2020, 'kategori' => 'Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'Deskripsi buku 1', 'is_favorite' => true],
            (object) ['id_buku' => 2, 'judul' => 'Buku 2', 'penulis' => 'Pengarang 2', 'tahun' => 2021, 'kategori' => 'Non-Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'Deskripsi buku 2', 'is_favorite' => true],
        ];

        $books = array_values(array_filter($allBooks, fn ($b) => in_array($b->id_buku, $favorites)));

        return view('pages.DaftarBuku.favorite', compact('books'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Buku $buku)
    {
        //
    }

    public function update(Request $request, Buku $buku)
    {
        //
    }

    public function destroy(Buku $buku)
    {
        //
    }
}
