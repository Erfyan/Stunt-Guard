<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelayananKesehatan extends Model
{
    protected $table = 'pelayanan_kesehatans';
    
    protected $fillable = [
        'pemeriksaan_id',
        'asi_eksklusif',
        'vitamin_a',
        'obat_cacing',
        'mt_pemulihan',
        'penyuluhan',
        'topik_penyuluhan',
        'rujukan',
        'keterangan'
    ];

    // Relasi ke Pemeriksaan (belongs to)
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'pemeriksaan_id');
    }

    // Relasi ke Imunisasi (one-to-one)
    public function imunisasi()
    {
        return $this->hasOne(Imunisasi::class, 'pelayanan_id');
    }
}