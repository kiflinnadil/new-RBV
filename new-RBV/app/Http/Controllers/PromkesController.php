<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PromkesController extends Controller
{
    private function getDummyData(): Collection
    {
        return collect([
            ['id' => 1, 'judul' => 'Panduan Penggunaan Website RBV',            'deskripsi' => 'Panduan lengkap penggunaan website.', 'link' => null, 'file' => 'dummy/panduan-rbv.pdf',     'created_at' => '2026-02-02'],
            ['id' => 2, 'judul' => 'Infografis Pencegahan DBD 2026',             'deskripsi' => 'Infografis edukasi DBD.',            'link' => null, 'file' => 'dummy/infografis-dbd.pdf', 'created_at' => '2026-01-28'],
            ['id' => 3, 'judul' => 'Materi Penyuluhan Gizi Seimbang',            'deskripsi' => 'Materi edukasi gizi.',               'link' => null, 'file' => 'dummy/gizi-seimbang.pdf', 'created_at' => '2026-01-20'],
            ['id' => 4, 'judul' => 'Leaflet Cuci Tangan Pakai Sabun (CTPS)',     'deskripsi' => 'Leaflet CTPS 6 langkah.',           'link' => null, 'file' => 'dummy/ctps.pdf',           'created_at' => '2026-01-10'],
            ['id' => 5, 'judul' => 'Video Edukasi Kesehatan Ibu dan Anak',       'deskripsi' => 'Video edukasi KIA.',                'link' => 'https://youtube.com', 'file' => null,           'created_at' => '2026-01-05'],
            ['id' => 6, 'judul' => 'Poster Imunisasi Dasar Lengkap',             'deskripsi' => 'Poster jadwal imunisasi.',          'link' => null, 'file' => 'dummy/imunisasi.pdf',      'created_at' => '2025-12-20'],
        ])->map(fn ($item) => (object) $item);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = $this->getDummyData();

        if ($search) {
            $data = $data->filter(fn ($item) => str_contains(strtolower($item->judul), strtolower($search)));
        }

        $perPage = 10;
        $page = $request->input('page', 1);
        $items = $data->forPage($page, $perPage)->values();

        $promkes = new LengthAwarePaginator($items, $data->count(), $perPage, $page, [
            'path' => $request->url(), 'query' => $request->query(),
        ]);

        return view('pages.Layanan.promkes.promkes', compact('promkes'));
    }

    public function create()
    {
        return view('pages.Layanan.promkes.promkescreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'link' => 'nullable|url|max:255',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // TODO: simpan ke database
        // $path = $request->hasFile('file') ? $request->file('file')->store('promkes', 'public') : null;
        // Promkes::create([...]);

        return redirect()->route('pages.Layanan.promkes.promkes')->with('success', 'Data Promkes berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $promkes = $this->getDummyData()->firstWhere('id', (int) $id);
        abort_if(! $promkes, 404);

        return view('pages.Layanan.promkes.promkesedit', compact('promkes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'link' => 'nullable|url|max:255',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // TODO: update di database

        return redirect()->route('pages.Layanan.promkes.promkes')->with('success', 'Data Promkes berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // TODO: hapus dari database
        return redirect()->route('pages.Layanan.promkes.promkes')->with('success', 'Data Promkes berhasil dihapus.');
    }
}
