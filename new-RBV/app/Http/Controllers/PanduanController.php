<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PanduanController extends Controller
{
    private function getDummyData(): Collection
    {
        return collect([
            ['id' => 1,  'judul' => 'Panduan Penggunaan Website RBV',              'file' => 'dummy/panduan-rbv.pdf',          'created_at' => '2026-02-02'],
            ['id' => 2,  'judul' => 'SOP Triase Pasien IGD – Rev. 3',              'file' => 'dummy/sop-triase-igd.pdf',       'created_at' => '2026-02-02'],
            ['id' => 3,  'judul' => 'Pedoman Pelayanan Rawat Inap 2026',           'file' => 'dummy/pedoman-ranap.pdf',        'created_at' => '2026-01-15'],
            ['id' => 4,  'judul' => 'SOP Dispensing Obat Farmasi Rawat Jalan',     'file' => 'dummy/sop-dispensing.pdf',       'created_at' => '2026-01-08'],
            ['id' => 5,  'judul' => 'SOP Pemeriksaan Laboratorium Klinik',         'file' => 'dummy/sop-lab-klinik.pdf',       'created_at' => '2026-01-03'],
            ['id' => 6,  'judul' => 'Panduan Pengelolaan Rekam Medis Elektronik',  'file' => 'dummy/panduan-rme.pdf',          'created_at' => '2025-12-20'],
            ['id' => 7,  'judul' => 'SOP Sterilisasi Alat Medis CSSD',             'file' => 'dummy/sop-cssd.pdf',             'created_at' => '2025-12-10'],
            ['id' => 8,  'judul' => 'Pedoman Keselamatan Pasien (Patient Safety)', 'file' => 'dummy/pedoman-patient-safety.pdf', 'created_at' => '2025-11-01'],
            ['id' => 9,  'judul' => 'SOP Pelayanan Radiologi dan Diagnostik',      'file' => 'dummy/sop-radiologi.pdf',        'created_at' => '2025-10-15'],
            ['id' => 10, 'judul' => 'SOP Penanganan Limbah Medis B3',              'file' => 'dummy/sop-limbah-b3.pdf',        'created_at' => '2025-09-25'],
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

        $panduans = new LengthAwarePaginator($items, $data->count(), $perPage, $page, [
            'path' => $request->url(), 'query' => $request->query(),
        ]);

        return view('pages.Layanan.panduan,pedoman dan SOP.panduan', compact('panduans'));
    }

    public function create()
    {

        return view('pages.Layanan.panduan,pedoman dan SOP.panduancreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:20480',
        ]);

        return redirect()->route('pages.Layanan.panduan,pedoman dan SOP.panduan')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $panduan = $this->getDummyData()->firstWhere('id', (int) $id);
        abort_if(! $panduan, 404);

        return view('pages.Layanan.panduan,pedoman dan SOP.panduanedit', compact('panduan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        return redirect()->route('pages.Layanan.panduan,pedoman dan SOP.panduan')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        return redirect()->route('pages.Layanan.panduan,pedoman dan SOP.panduan')->with('success', 'Dokumen berhasil dihapus.');
    }
}
