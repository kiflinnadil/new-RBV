<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use SoftDeletes;

    protected $table = 'unit_kerja';
    protected $primaryKey = 'id';
    protected $fillable = [
        'unit_name',
        'slug',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_unit_kerja', 'unit_kerja_id', 'user_id');
    }
}