<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingSurat extends Model
{
    protected $table = 'tracking_surats';

    protected $fillable = ['surat_type', 'surat_id', 'user_id', 'aksi', 'keterangan'];

    public function surat()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
