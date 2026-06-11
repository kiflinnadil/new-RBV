<?php

namespace App\Exports;

use App\Models\SuratMasuk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuratMasukExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = SuratMasuk::with([
            'tags.user'
        ]);

        // FILTER BULAN DARI TANGGAL SURAT
        if (!empty($this->bulan)) {
            $query->whereMonth('tanggal_surat', $this->bulan);
        }

        // FILTER TAHUN DARI TANGGAL SURAT
        if (!empty($this->tahun)) {
            $query->whereYear('tanggal_surat', $this->tahun);
        }

        // URUTKAN BERDASARKAN NOMOR AGENDA
        return $query
            ->orderBy('nomor_agenda', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'TGL SURAT',
            'TGL SURAT DITERIMA',
            'NO. SURAT',
            'NOMOR AGENDA',
            'PERIHAL',
            'DARI',
            'DISPOSISI',
        ];
    }

    public function map($surat): array
    {
        $disposisi = $surat->tags
            ->filter(function ($tag) {
                return in_array(
                    $tag->user->id_jabatan ?? null,
                    [1, 2]
                );
            })
            ->map(function ($tag) {

                if ($tag->user->id_jabatan == 1) {
                    return 'Direktur';
                }

                if ($tag->user->id_jabatan == 2) {
                    return 'Kabag';
                }

                return null;
            })
            ->filter()
            ->unique()
            ->implode(', ');

        return [

            $surat->tanggal_surat
                ? Carbon::parse($surat->tanggal_surat)
                    ->format('d/m/Y')
                : '-',

            $surat->tanggal_masuk
                ? Carbon::parse($surat->tanggal_masuk)
                    ->format('d/m/Y')
                : '-',

            $surat->nomor_surat ?? '-',

            $surat->nomor_agenda ?? '-',

            $surat->perihal ?? '-',

            $surat->asal_surat ?? '-',

            $disposisi ?: '-',
        ];
    }
}