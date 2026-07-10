<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    protected $table = 'imunisasis';
    
    protected $fillable = ['pelayanan_id', 'jenis_imunisasi', 'tanggal', 'keterangan'];

    // Relasi ke PelayananKesehatan (belongs to)
    public function pelayananKesehatan()
    {
        return $this->belongsTo(PelayananKesehatan::class, 'pelayanan_id');
    }
}