<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = collect([
            (object) [
                'id' => 1,
                'nomor_surat' => '001/RSCH/SK/III/2026',
                'tanggal_keluar' => Carbon::now()->subDays(1),
                'tujuan' => 'RSUD Kota Sebelah',
                'perihal' => 'Pengiriman Sampel Laboratorium',
                'status' => 'disetujui',
                'prioritas' => 'biasa',
            ],
            (object) [
                'id' => 2,
                'nomor_surat' => '002/RSCH/SK/IV/2026',
                'tanggal_keluar' => Carbon::now()->subDays(3),
                'tujuan' => 'Dinas Kesehatan Jember',
                'perihal' => 'Permohonan Kerjasama Pelayanan',
                'status' => 'disetujui',
                'prioritas' => 'segera',
            ],
        ]);

        $suratKeluar = new \Illuminate\Pagination\LengthAwarePaginator(
            $suratKeluar, $suratKeluar->count(), 15
        );
        $suratKeluar->setPath(url()->current());

        return view('pages.E-Office.SuratKeluar.suratkeluar', compact('suratKeluar'));
    }

    public function show($id)
    {
        // $surat = SuratKeluar::findOrFail($id);

        $surat = (object) [
            'id' => $id,
            'nomor_surat' => '001/RSCH/SK/III/2026',
            'tanggal_keluar' => Carbon::now()->subDays(1),
            'tujuan' => 'RSUD Kota Sebelah',
            'perihal' => 'Pengiriman Sampel Laboratorium',
            'status' => 'disetujui',
            'file_surat' => null,
        ];

        return view('pages.E-Office.SuratKeluar.suratkeluar_show', compact('surat'));
    }

    public function create()
    {
        return view('pages.E-Office.SuratKeluar.suratkeluar_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string',
            'tanggal_keluar' => 'required|date',
            'tujuan' => 'required|string',
            'perihal' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        return redirect()->route('eoffice.surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dibuat.');
    }

    public function edit($id)
    {
        if (! in_array(auth()->user()->role, ['super_admin', 'sekretaris'])) {
            abort(403);
        }

        // $surat = SuratKeluar::findOrFail($id);

        $surat = (object) [
            'id' => $id,
            'nomor_surat' => '001/RSCH/SK/III/2026',
            'tanggal_keluar' => Carbon::now()->subDays(3),
            'tujuan' => 'Dinas Kesehatan Jember',
            'perihal' => 'Permohonan Kerjasama',
            'file_surat' => null,
        ];

        return view('pages.E-Office.SuratKeluar.suratkeluar_edit', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        if (! in_array(auth()->user()->role, ['super_admin', 'sekretaris'])) {
            abort(403);
        }

        $request->validate([
            'nomor_surat' => 'required|string',
            'tanggal_keluar' => 'required|date',
            'tujuan' => 'required|string',
            'perihal' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        return redirect()->route('eoffice.surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function exportAll()
    {
        return redirect()->back()->with('info', 'Fitur export segera hadir.');
    }

    public function pdf($id)
    {
        return redirect()->back()->with('info', 'Fitur PDF segera hadir.');
    }
}
