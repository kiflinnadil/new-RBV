<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panduan extends Model
{
    protected $primaryKey = 'id_panduan';

    protected $fillable = [
        'judul',
        'file',
    ];
}