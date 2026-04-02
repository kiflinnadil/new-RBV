<?php

// ============================================================
// app/Models/SuratMasuk.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_agenda', 'nomor_surat', 'tanggal_surat', 'tanggal_masuk',
        'asal_surat', 'perihal', 'jenis', 'prioritas', 'catatan',
        'file_scan', 'status', 'catatan_tolak', 'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_masuk' => 'datetime',
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function tags()
    {
        return $this->morphMany(SuratTag::class, 'surat');
    }

    public function persetujuan()
    {
        return $this->morphMany(Persetujuan::class, 'surat');
    }

    public function tracking()
    {
        return $this->morphMany(TrackingSurat::class, 'surat');
    }

    public function notifikasi()
    {
        return $this->morphMany(Notifikasi::class, 'surat');
    }

    // User yang di-tag pada surat ini
    public function penerima()
    {
        return $this->hasManyThrough(User::class, SuratTag::class,
            'surat_id', 'id', 'id', 'user_id')
            ->where('surat_tags.surat_type', self::class);
    }
}
