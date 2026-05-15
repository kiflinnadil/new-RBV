<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'nomor_surat',

        'tanggal_keluar',

        'tujuan',

        'perihal',

        'isi',

        'keterangan',

        'jenis',

        'prioritas',

        'status',

        'file_scan',

        'dibuat_oleh',

    ];

    protected $casts = [

        'tanggal_keluar' => 'date',

    ];

    public function pembuat()
    {
        return $this->belongsTo(
            User::class,
            'dibuat_oleh',
            'id_user'
        );
    }
}