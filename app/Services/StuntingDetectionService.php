<?php

namespace App\Services;

class StuntingDetectionService
{
    public function analyze($berat, $tinggi, $umurBulan, $jenisKelamin)
    {
        // Referensi WHO sederhana
        $data = [
            'Laki-laki' => [
                0 => [49.9, 1.9, 3.3, 0.4],
                6 => [67.6, 2.2, 7.9, 0.9],
                12 => [76.1, 2.4, 10.0, 1.0],
                24 => [87.8, 3.0, 12.3, 1.2],
                36 => [96.1, 3.4, 14.2, 1.4],
                60 => [110.0, 4.0, 18.5, 2.0],
            ],
            'Perempuan' => [
                0 => [49.1, 1.9, 3.2, 0.4],
                6 => [65.7, 2.2, 7.3, 0.8],
                12 => [74.0, 2.4, 9.1, 1.0],
                24 => [86.4, 3.0, 12.0, 1.2],
                36 => [95.0, 3.4, 13.7, 1.4],
                60 => [109.0, 4.0, 18.0, 2.0],
            ]
        ];

        $ref = $data[$jenisKelamin] ?? $data['Laki-laki'];
        $keys = array_keys($ref);
        $closest = $keys[0];
        foreach ($keys as $key) {
            if (abs($key - $umurBulan) < abs($closest - $umurBulan)) {
                $closest = $key;
            }
        }
        list($medianTb, $sdTb, $medianBb, $sdBb) = $ref[$closest];

        $zTb = ($sdTb != 0) ? round(($tinggi - $medianTb) / $sdTb, 2) : 0;
        $zBb = ($sdBb != 0) ? round(($berat - $medianBb) / $sdBb, 2) : 0;

        $status_gizi = 'Normal';
        $status_stunting = 'Normal';
        $message = 'Pertumbuhan normal.';

        if ($zTb < -2.0) {
            $status_stunting = 'Stunted';
            $status_gizi = 'Stunting';
            $message = 'Anak terindikasi STUNTING. Segera rujuk ke puskesmas.';
        } elseif ($zBb < -2.0 && $zTb >= -2.0) {
            $status_gizi = 'Underweight';
            $message = 'Berat badan kurang (Underweight). Tingkatkan asupan gizi.';
        } elseif ($zBb > 2.0 && $zTb >= -2.0) {
            $status_gizi = 'Overweight / Obese';
            $message = 'Berat badan berlebih. Perhatikan pola makan.';
        }

        return [
            'status_gizi' => $status_gizi,
            'status_stunting' => $status_stunting,
            'z_tb' => $zTb,
            'z_bb' => $zBb,
            'message' => $message,
            'bb_tidak_nak' => 'Tidak',
        ];
    }
}