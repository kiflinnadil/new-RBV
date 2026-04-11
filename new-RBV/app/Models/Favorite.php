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

    protected $primaryKey = 'id_favorite';

    protected $fillable = [
        'id_user',
        'id_buku'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}