<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = [
        'user_id', 'judul', 'pesan', 'url', 'dibaca', 'surat_type', 'surat_id',
    ];

    protected $casts = ['dibaca' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function surat()
    {
        return $this->morphTo();
    }

    public static function kirim(array $userIds, string $judul, string $pesan, string $url, $surat)
    {
        foreach (array_unique($userIds) as $userId) {
            if (! $userId) {
                continue;
            }
            self::create([
                'user_id' => $userId,
                'judul' => $judul,
                'pesan' => $pesan,
                'url' => $url,
                'surat_type' => get_class($surat),
                'surat_id' => $surat->id,
            ]);
        }
    }
}
