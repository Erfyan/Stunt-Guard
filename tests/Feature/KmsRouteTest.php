<?php

namespace Tests\Feature;

use App\Models\Balita;
use App\Models\Ibu;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KmsRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_kms_pages_are_accessible_for_authenticated_user(): void
    {
        $user = User::create([
            'nama' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'Kader',
            'status' => 'Aktif',
        ]);

        $posyandu = Posyandu::create([
            'nama_posyandu' => 'Posyandu Test',
            'desa' => 'Desa Test',
            'kecamatan' => 'Kec Test',
            'kabupaten' => 'Kab Test',
            'alamat' => 'Alamat Test',
            'latitude' => -5.12345678,
            'longitude' => 119.45678901,
            'no_hp' => '081234567890',
        ]);

        $ibu = Ibu::create([
            'user_id' => $user->id,
            'nik' => '1234567890123456',
            'nama_ibu' => 'Ibu Test',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Alamat Ibu',
            'no_hp' => '081111111111',
        ]);

        $balita = Balita::create([
            'ibu_id' => $ibu->id,
            'posyandu_id' => $posyandu->id,
            'nama_balita' => 'Balita Test',
            'nik' => '6543210987654321',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2022-01-01',
            'berat_lahir' => 3.1,
            'panjang_lahir' => 49.5,
            'status' => 'Aktif',
        ]);

        $this->actingAs($user);

        $this->get('/kms')->assertStatus(200);
        $this->get('/kms/' . $balita->id)->assertStatus(200);
    }
}
