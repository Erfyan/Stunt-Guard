<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama', 'username', 'email', 'password', 'role', 'no_hp', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Ibu (one-to-one)
    public function ibu()
    {
        return $this->hasOne(Ibu::class, 'user_id');
    }

    // Relasi ke Posyandu (jika role Kader, petugas atau admin bisa punya posyandu_id, tapi kita simpan di user untuk memudahkan)
    // Karena di ERD tidak ada posyandu_id di user, kita skip dulu. Nanti kita handle via relasi.
}