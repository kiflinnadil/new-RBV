<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repositori extends Model
{
    protected $primaryKey = 'id_repositori';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file'
    ];
}
