<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Buku;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'buku_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class,'buku_id');
    }
}