<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ibu extends Model
{
    protected $table = 'ibuses';
    
    protected $fillable = [
        'user_id',
        'nik',
        'nama_ibu',
        'tanggal_lahir',
        'alamat',
        'no_hp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balitas()
    {
        return $this->hasMany(Balita::class, 'ibu_id');
    }
}