<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaans';
    
    protected $fillable = [
        'balita_id',
        'tanggal',
        'umur_bulan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'cara_ukur',
        'zscore',          // menyimpan z-score TB/U
        'status_gizi',
        'status_stunting',
        'bb_tidak_nak',
        'catatan',
        'petugas',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke Balita
    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_id');
    }

    // Relasi ke User pembuat
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke PelayananKesehatan (one-to-one)
    public function pelayananKesehatan()
    {
        return $this->hasOne(PelayananKesehatan::class, 'pemeriksaan_id');
    }
}