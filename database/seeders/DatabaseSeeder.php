<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Posyandu;
use App\Models\Ibu;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Posyandu
        $posyandu1 = Posyandu::create([
            'nama_posyandu' => 'Posyandu Mawar',
            'desa' => 'Parang Loe',
            'kecamatan' => 'Tamalanrea',
            'kabupaten' => 'Makassar',
            'alamat' => 'Jl. Kesehatan No. 1',
            'latitude' => -5.12345678,
            'longitude' => 119.45678901,
            'no_hp' => '081234567890'
        ]);

        // 2. User Admin
        $admin = User::create([
            'nama' => 'Admin Utama',
            'username' => 'admin',
            'email' => 'admin@stuntguard.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'no_hp' => '081234567890',
            'status' => 'Aktif'
        ]);

        // 3. User Kader
        $kader = User::create([
            'nama' => 'Kader Aisyah',
            'username' => 'kader_mawar',
            'email' => 'kader@posyandu.com',
            'password' => Hash::make('password'),
            'role' => 'Kader',
            'no_hp' => '081298765432',
            'status' => 'Aktif'
        ]);

        // 4. User Ibu (Orang Tua)
        $userIbu = User::create([
            'nama' => 'Ani Sulastri',
            'username' => 'ibu_ani',
            'email' => 'ani@example.com',
            'password' => Hash::make('password'),
            'role' => 'Ibu',
            'no_hp' => '081355667788',
            'status' => 'Aktif'
        ]);

        // 5. Data Ibu (terhubung ke user Ibu)
        $ibu = Ibu::create([
            'user_id' => $userIbu->id,
            'nik' => '3273012345678901',
            'nama_ibu' => 'Ani Sulastri',
            'tanggal_lahir' => '1995-05-10',
            'alamat' => 'Jl. Mawar No. 12',
            'no_hp' => '081355667788'
        ]);

        // 6. Balita (milik Ibu)
        \App\Models\Balita::create([
            'ibu_id' => $ibu->id,
            'posyandu_id' => $posyandu1->id,
            'nama_balita' => 'Budi Pratama',
            'nik' => '3273012345678902',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2022-01-15',
            'berat_lahir' => 3.20,
            'panjang_lahir' => 49.00,
            'status' => 'Aktif'
        ]);
    }
}