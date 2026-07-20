<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posyandu;

class PosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posyandus = [
            ['nama_posyandu' => 'Posyandu Melati', 'kecamatan' => 'Kec. A'],
            ['nama_posyandu' => 'Posyandu Anggrek', 'kecamatan' => 'Kec. B'],
            ['nama_posyandu' => 'Posyandu Mawar', 'kecamatan' => 'Kec. C'],
        ];

        foreach ($posyandus as $data) {
            Posyandu::create($data);
        }
    }
}
