<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';
    
    protected $primaryKey = 'id_video';

    protected $fillable = [
        'judul',
        'tanggal',
        'deskripsi',
        'file_url'
    ];

    public function getYoutubeId()
    {
        preg_match(
            '/(youtube\.com\/embed\/|youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/',
            $this->file_url,
            $matches
        );

        return $matches[2] ?? null;
    }
}