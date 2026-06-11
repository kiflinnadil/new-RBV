<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_masuk',
        'asal_surat',
        'perihal',
        'jenis',
        'prioritas',
        'catatan',
        'file_scan',
        'status',
        'catatan_tolak',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_masuk' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | PEMBUAT
    |--------------------------------------------------------------------------
    */

    public function pembuat()
    {
        return $this->belongsTo(
            User::class,
            'dibuat_oleh',
            'id_user'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TAG SURAT
    |--------------------------------------------------------------------------
    */

    public function tags()
    {
        return $this->morphMany(
            SuratTag::class,
            'surat'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PERSETUJUAN
    |--------------------------------------------------------------------------
    */

    public function persetujuans()
    {
        return $this->morphMany(
            Persetujuan::class,
            'surat'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TRACKING
    |--------------------------------------------------------------------------
    */

    public function tracking()
    {
        return $this->morphMany(
            TrackingSurat::class,
            'surat'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI
    |--------------------------------------------------------------------------
    */

    public function notifikasi()
    {
        return $this->morphMany(
            Notifikasi::class,
            'surat'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PENERIMA TAG
    |--------------------------------------------------------------------------
    */

    public function penerima()
    {
        return $this->hasManyThrough(
            User::class,
            SuratTag::class,
            'surat_id',
            'id_user',
            'id',
            'user_id'
        )->where(
            'surat_tags.surat_type',
            self::class
        );
    }
}