<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'NIK',
        'nama_lengkap',
        'id_jabatan',
        'id_role',
        'id_unit_kerja',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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

    public function roleRelation()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function getRoleAttribute()
    {
        return $this->roleRelation?->nama_role;
    }

    public function unitKerjaRelation()
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_kerja');
    }

    public function getUnitKerjaAttribute()
    {
        return $this->unitKerjaRelation?->nama_unit;
    }

    public function jabatanRelation()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    public function getJabatanAttribute()
    {
        return $this->jabatanRelation?->nama_jabatan;
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'id_user');
    }

    public function hasRole($roles)
    {
        return in_array(

            $this->role,

            (array) $roles
        );
    }
}