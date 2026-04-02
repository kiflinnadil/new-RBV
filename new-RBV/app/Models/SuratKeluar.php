<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_surat', 'tanggal_keluar', 'tujuan', 'perihal', 'isi',
        'keterangan', 'jenis', 'prioritas', 'status', 'catatan_tolak', 'dibuat_oleh',
    ];

    protected $casts = ['tanggal_keluar' => 'date'];

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
}
