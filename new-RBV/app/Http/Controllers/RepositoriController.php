<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RepositoriController extends Controller
{
    private function getDummyData(): Collection
    {
        return collect([
            ['id' => 1, 'judul' => 'Efektivitas Terapi Insulin Pada Pasien DM Tipe 2',         'deskripsi' => 'Penelitian terapi insulin rawat inap.',   'file' => 'dummy/jurnal-insulin.pdf',          'created_at' => '2026-02-02'],
            ['id' => 2, 'judul' => 'Hubungan Tingkat Stres Perawat dengan Kualitas Pelayanan', 'deskripsi' => 'Studi korelasi stres dan pelayanan IGD.', 'file' => 'dummy/skripsi-stres-perawat.pdf',   'created_at' => '2026-01-15'],
            ['id' => 3, 'judul' => 'Implementasi Patient Safety Culture di RS Swasta',        'deskripsi' => 'Prosiding seminar patient safety.',        'file' => 'dummy/prosiding-patient-safety.pdf', 'created_at' => '2025-11-10'],
            ['id' => 4, 'judul' => 'Analisis Kepatuhan Hand Hygiene Tenaga Medis 2024',       'deskripsi' => 'Laporan audit hand hygiene.',             'file' => 'dummy/laporan-hand-hygiene.pdf',    'created_at' => '2025-10-05'],
            ['id' => 5, 'judul' => 'Peran Farmasi Klinik dalam Pengurangan Medication Error', 'deskripsi' => 'Jurnal farmasi klinik nasional.',          'file' => 'dummy/jurnal-farmasi-klinik.pdf',   'created_at' => '2025-09-20'],
            ['id' => 6, 'judul' => 'Kepuasan Pasien Rawat Jalan terhadap Mutu Pelayanan',     'deskripsi' => 'Skripsi kepuasan pelayanan poli umum.',   'file' => 'dummy/skripsi-kepuasan-pasien.pdf', 'created_at' => '2024-06-01'],
        ])->map(fn ($item) => (object) $item);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = $this->getDummyData();

        if ($search) {
            $data = $data->filter(fn ($item) => str_contains(strtolower($item->judul), strtolower($search))
            );
        }

        $perPage = 10;
        $page = $request->input('page', 1);
        $items = $data->forPage($page, $perPage)->values();

        $repositoris = new LengthAwarePaginator($items, $data->count(), $perPage, $page, [
            'path' => $request->url(), 'query' => $request->query(),
        ]);

        $kategoris = [];
        $kategori = null;

        return view('pages.Layanan.repositori.repositori', compact('repositoris', 'kategoris', 'kategori'));
    }

    public function create()
    {
        return view('pages.Layanan.repositori.repositoricreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'file' => 'required|file|mimes:pdf|max:20480',
        ]);

        // TODO: simpan ke database
        // $path = $request->file('file')->store('repositori', 'public');
        // Repositori::create(['judul' => $request->judul, 'deskripsi' => $request->deskripsi, 'file' => $path]);

        return redirect()->route('pages.Layanan.repositori.repositori')->with('success', 'Data Repositori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $repositori = $this->getDummyData()->firstWhere('id', (int) $id);
        abort_if(! $repositori, 404);

        return view('pages.Layanan.repositori.repositoriedit', compact('repositori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // TODO: update di database

        return redirect()->route('pages.Layanan.repositori.repositori')->with('success', 'Data Repositori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // TODO: hapus dari database
        return redirect()->route('pages.Layanan.repositori.repositori')->with('success', 'Data Repositori berhasil dihapus.');
    }
}
