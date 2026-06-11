<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'id_user',
        'judul',
        'pesan',
        'url',
        'tipe',
        'dibaca',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public static function kirim(int $idUser, string $judul, string $pesan, ?string $url = null, string $tipe = 'info'): void
    {
        self::create([
            'id_user' => $idUser,
            'judul' => $judul,
            'pesan' => $pesan,
            'url' => $url,
            'tipe' => $tipe,
            'dibaca' => false,
        ]);
    }

    public static function kirimKe(array $idUsers, string $judul, string $pesan, ?string $url = null, string $tipe = 'info'): void
    {
        foreach ($idUsers as $idUser) {
            self::kirim($idUser, $judul, $pesan, $url, $tipe);
        }
    }
}
