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
        'iam_id',
        'NIK',
        'name',
        'status',
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'id_user', 'id_role');
    }

    public function getRoleAttribute()
    {
        return $this->roles->first()?->nama_role;
    }

    public function unitKerjas()
    {
        return $this->belongsToMany(UnitKerja::class, 'user_unit_kerja', 'user_id', 'unit_kerja_id');
    }

    public function getUnitKerjaAttribute()
    {
        return $this->unitKerjas->first()?->unit_name;
    }

    public function jabatans()
    {
        return $this->belongsToMany(Jabatan::class, 'jabatan_user', 'id_user', 'id_jabatan');
    }

    public function getJabatanAttribute()
    {
        return $this->jabatans->first()?->nama_jabatan;
    }

    public function getIdRoleAttribute()
    {
        return $this->roles->first()?->id_role;
    }

    public function getIdJabatanAttribute()
    {
        return $this->jabatans->first()?->id_jabatan;
    }

    public function getIdUnitKerjaAttribute()
    {
        return $this->unitKerjas->first()?->id;
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