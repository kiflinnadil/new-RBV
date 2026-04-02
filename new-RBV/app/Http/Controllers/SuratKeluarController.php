<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = collect([
            (object) [
                'id' => 1,
                'nomor_surat' => '001/SK/III/2026',
                'tanggal_keluar' => Carbon::now()->subDays(1),
                'tujuan' => 'RSUD Kota Sebelah',
                'perihal' => 'Pengiriman Sampel Laboratorium',
                'status' => 'disetujui',
                'prioritas' => 'biasa',
            ],
        ]);

        $suratKeluar = new \Illuminate\Pagination\LengthAwarePaginator($suratKeluar, $suratKeluar->count(), 15);
        $suratKeluar->setPath(url()->current());

        return view('pages.E-Office.SuratKeluar.suratkeluar', compact('suratKeluar'));
    }

    public function show($id)
    {
        return 'Halaman Detail Surat Keluar Dummy untuk ID: '.$id;
    }

    public function create()
    {
        $nomorSurat = '001/SK/III/2026';

        return view('pages.E-Office.SuratKeluar.suratkeluar_create', compact('nomorSurat'));
    }
}
