<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'judul',
        'penulis',
        'kategori',
        'tahun',
        'deskripsi',
        'file_pdf',
        'cover'
    ];
}