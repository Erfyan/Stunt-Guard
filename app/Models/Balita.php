<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $table = 'balitas';
    
    protected $fillable = [
        'ibu_id',
        'posyandu_id',
        'nama_balita',   // <-- pastikan ada
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'berat_lahir',
        'panjang_lahir',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class, 'balita_id');
    }
}