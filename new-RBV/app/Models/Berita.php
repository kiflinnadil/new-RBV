<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'judul',
        'kategori',
        'tanggal',
        'deskripsi',
        'file_url',
        'cover'
    ];

}
