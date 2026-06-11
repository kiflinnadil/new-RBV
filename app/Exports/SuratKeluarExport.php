<?php

namespace App\Exports;

use App\Models\SuratKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuratKeluarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SuratKeluar::select(
            'tanggal_keluar',
            'nomor_surat',
            'tujuan',
            'perihal',
            'keterangan'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal Keluar',
            'Nomor Surat',
            'Tujuan',
            'Perihal',
            'Keterangan',
        ];
    }
}