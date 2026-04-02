<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTag extends Model
{
    protected $fillable = ['surat_type', 'surat_id', 'user_id'];

    public function surat()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
