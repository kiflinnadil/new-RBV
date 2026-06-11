<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model

{

    protected $table = 'unit_kerjas';
    protected $primaryKey = 'id_unit_kerja';
    protected $fillable = [
        'nama_unit',
        'kabid',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_unit_kerja', 'id_unit_kerja');
    }

}