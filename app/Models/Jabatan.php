<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model

{
    use HasFactory;

    protected $table = 'jabatans';
    protected $primaryKey = 'id_jabatan';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'nama_jabatan',
    ];
    public function users()

    {
        return $this->hasMany(User::class, 'id_jabatan');
    }
}