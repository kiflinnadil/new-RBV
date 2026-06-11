<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promkes extends Model
{
    protected $table = 'promkes';
    protected $primaryKey = 'id_promkes';

    protected $fillable = [
        'judul',
        'deskripsi',
        'link',
        'file'
    ];
}
