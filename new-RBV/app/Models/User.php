<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'NIK',
        'password',
        'nama_lengkap',
        'jabatan',
        'unit_kerja',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getAuthIdentifierName()
    {
        return 'NIK';
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class,'user_id');
    }

    public function hasRole($roles)
    {
        return in_array($this->role, (array) $roles);
    }
}