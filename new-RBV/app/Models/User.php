<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
        ];
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'id_user');
    }

    public function hasRole($roles)
    {
        return in_array($this->role, (array) $roles);
    }
}