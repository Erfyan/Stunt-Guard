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
            'posyandu_id' => $posyandu->id,
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