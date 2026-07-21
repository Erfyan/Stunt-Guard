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
        $this->call(PosyanduSeeder::class);
        // Grab the first Posyandu inserted by the seeder for later use
        $posyandu = Posyandu::first();

        // 1. User Admin
        User::create([
            'nama' => 'Administrator System',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'no_hp' => '081234567890',
            'status' => 'Aktif'
        ]);

        // 2. User Kader
        User::create([
            'nama' => 'Kader Siti',
            'username' => 'kader_siti',
            'email' => 'kader@example.com',
            'password' => Hash::make('password'),
            'role' => 'Kader',
            'posyandu_id' => $posyandu ? $posyandu->id : null,
            'no_hp' => '081234567891',
            'status' => 'Aktif'
        ]);

        // 3. User Puskesmas / Petugas
        User::create([
            'nama' => 'Petugas Puskesmas',
            'username' => 'puskesmas',
            'email' => 'puskesmas@example.com',
            'password' => Hash::make('password'),
            'role' => 'Puskesmas',
            'no_hp' => '081234567892',
            'status' => 'Aktif'
        ]);

        // 4. User Dinas Kesehatan
        User::create([
            'nama' => 'Dinas Kesehatan',
            'username' => 'dinas',
            'email' => 'dinas@example.com',
            'password' => Hash::make('password'),
            'role' => 'Dinas',
            'no_hp' => '081234567893',
            'status' => 'Aktif'
        ]);

        // 5. User Ibu (Orang Tua)
        $userIbu = User::create([
            'nama' => 'Ani Sulastri',
            'username' => 'ibu_ani',
            'email' => 'ani@example.com',
            'password' => Hash::make('password'),
            'role' => 'Ibu',
            'no_hp' => '081355667788',
            'status' => 'Aktif'
        ]);

        // 6. Data Ibu (terhubung ke user Ibu)
        $ibu = Ibu::create([
            'user_id' => $userIbu->id,
            'nik' => '3273012345678901',
            'nama_ibu' => 'Ani Sulastri',
            'tanggal_lahir' => '1995-05-10',
            'alamat' => 'Jl. Mawar No. 12',
            'no_hp' => '081355667788'
        ]);

        // 7. Balita (milik Ibu)
        \App\Models\Balita::create([
            'ibu_id' => $ibu->id,
            'posyandu_id' => $posyandu ? $posyandu->id : null,
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