<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    protected $fillable = [
        'surat_type', 'surat_id', 'user_id',
        'role_approver', 'status', 'catatan', 'approved_at',
    ];

    protected $casts = ['approved_at' => 'datetime'];

    public function surat()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
