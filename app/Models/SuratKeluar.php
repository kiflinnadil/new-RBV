<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $fillable = [
        'tanggal_keluar',
        'nomor_surat',
        'tujuan',
        'perihal',
        'keterangan',
        'file_scan',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
    ];
}