<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';

    protected $primaryKey = 'id_artikel';

    protected $fillable = [
        'judul',
        'tanggal',
        'deskripsi',
        'cover',
        'file_pdf'
    ];
}