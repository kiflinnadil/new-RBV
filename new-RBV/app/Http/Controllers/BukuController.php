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
            (object) [
                'id_buku' => 5,
                'judul' => 'Sang Alkemis',
                'penulis' => 'Pengarang 5',
                'tahun' => 2024,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'Deskripsi buku 5',
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
                'judul' => 'Dunia Kafka',
                'penulis' => 'Haruki Murakami',
                'tahun' => 2020,
                'kategori' => 'Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_favorite' => in_array(1, $favorites),
            ],
            (object) [
                'id_buku' => 2,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun' => 2021,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_favorite' => in_array(2, $favorites),
            ],
            (object) [
                'id_buku' => 3,
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'tahun' => 2022,
                'kategori' => 'Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_favorite' => in_array(3, $favorites),
            ],
            (object) [
                'id_buku' => 4,
                'judul' => 'Sang Alkemis',
                'penulis' => 'Paulo Coelho',
                'tahun' => 2023,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_favorite' => in_array(4, $favorites),
            ],
            (object) [
                'id_buku' => 5,
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'tahun' => 2022,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_favorite' => in_array(5, $favorites),
            ],
            (object) [
                'id_buku' => 6,
                'judul' => 'The Power of Now',
                'penulis' => 'Eckhart Tolle',
                'tahun' => 2020,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_favorite' => in_array(6, $favorites),
            ],
            (object) [
                'id_buku' => 7,
                'judul' => 'Sapiens: A Brief History of Humankind',
                'penulis' => 'Yuval Noah Harari',
                'tahun' => 2018,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1fUVVVK1mx-YH3HcN_J_iDnQMcYGC2uWz/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_favorite' => in_array(7, $favorites),
            ],
            (object) [
                'id_buku' => 8,
                'judul' => 'Madilog',
                'penulis' => 'Tan Malaka',
                'tahun' => 2023,
                'kategori' => 'Non-Fiksi',
                'file_pdf' => 'https://drive.google.com/file/d/1Wp9I-Jcl3FW5Kpx_e8wQ2H20N_uWjN6e/view?usp=drive_link',
                'cover' => 'cover.png',
                'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'is_favorite' => in_array(8, $favorites),
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
            (object) ['id_buku' => 1, 'judul' => 'Dunia Kafka', 'penulis' => 'Haruki Murakami', 'tahun' => 2020, 'kategori' => 'Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'is_favorite' => true],
            (object) ['id_buku' => 2, 'judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'tahun' => 2021, 'kategori' => 'Non-Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'is_favorite' => true],
            (object) ['id_buku' => 3, 'judul' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'tahun' => 2022, 'kategori' => 'Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'is_favorite' => true],
            (object) ['id_buku' => 4, 'judul' => 'Sang Alkemis', 'penulis' => 'paulo coelho', 'tahun' => 2023, 'kategori' => 'Non-Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'is_favorite' => true],
            (object) ['id_buku' => 5, 'judul' => 'Atomic Habits', 'penulis' => 'James Clear', 'tahun' => 2022, 'kategori' => 'Non-Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'is_favorite' => true],
            (object) ['id_buku' => 6, 'judul' => 'The Power of Now', 'penulis' => 'Eckhart Tolle', 'tahun' => 2020, 'kategori' => 'Non-Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'is_favorite' => true],
            (object) ['id_buku' => 7, 'judul' => 'Sapiens: A Brief History of Humankind', 'penulis' => 'Yuval Noah Harari', 'tahun' => 2018, 'kategori' => 'Non-Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'is_favorite' => true],
            (object) ['id_buku' => 8, 'judul' => 'Madilog', 'penulis' => 'Tan Malaka', 'tahun' => 2023, 'kategori' => 'Non-Fiksi', 'cover' => 'cover.png', 'deskripsi' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'is_favorite' => true],
        ];

        $books = array_values(array_filter($allBooks, fn ($b) => in_array($b->id_buku, $favorites)));

        return view('pages.DaftarBuku.favorite', compact('books'));
    }

    public function create()
    {
        return view('pages.DaftarBuku.createbuku');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
            'file_buku' => 'required|file|mimes:pdf',
            'cover' => 'required|image',
        ]);

        $filePdf = $request->file('file_buku')->store('books', 'public');
        $cover = $request->file('cover')->store('covers', 'public');

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->pengarang,
            'tahun' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'file_pdf' => $filePdf,
            'cover' => $cover,
        ]);

        return redirect()->route('books.index');
    }

    public function edit($id)
    {
        // $book = Buku::findOrFail($id);

        $book = (object) [
            'id' => $id,
            'judul' => 'Contoh Judul '.$id,
            'penulis' => 'Contoh Penulis '.$id,
            'tahun' => 2023,
            'deskripsi' => 'Contoh Deskripsi',
            'cover' => 'cover.png',
            'file_pdf' => 'file.pdf',
        ];

        return view('pages.DaftarBuku.editbuku', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric',
            'deskripsi' => 'required',
            'file_buku' => 'nullable|file|mimes:pdf|max:20480',
            'cover' => 'nullable|image|max:20480',
        ]);

        $buku = Buku::findOrFail($id);

        $buku->judul = $request->judul;
        $buku->penulis = $request->pengarang;
        $buku->tahun = $request->tahun_terbit;
        $buku->deskripsi = $request->deskripsi;

        if ($request->hasFile('file_buku')) {
            $buku->file_pdf = $request->file('file_buku')->store('books', 'public');
        }

        if ($request->hasFile('cover')) {
            $buku->cover = $request->file('cover')->store('covers', 'public');
        }

        $buku->save();

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function delete(Buku $buku)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        if ($buku->file_pdf) {
            Storage::disk('public')->delete($buku->file_pdf);
        }

        $buku->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
