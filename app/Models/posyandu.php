<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    protected $fillable = [
        'nama_posyandu',
        'desa',
        'kecamatan',
        'kabupaten',
        'alamat',
        'latitude',
        'longitude',
        'no_hp'
    ];

    public function balitas()
    {
        return $this->hasMany(Balita::class);
    }
}