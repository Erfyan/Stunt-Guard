<?php

if (!function_exists('statusColorClass')) {
    function statusColorClass($status_gizi, $status_stunting)
    {
        // Stunting - prioritas utama (merah)
        if (in_array($status_stunting, ['Severely Stunted', 'Stunted'])) {
            return 'bg-red-200 text-red-800';
        }
        // Wasting (kurus akut) - oranye
        if (in_array($status_gizi, ['Wasting', 'Severely Wasted'])) {
            return 'bg-orange-200 text-orange-800';
        }
        // Underweight (kurang berat badan) - kuning
        if (in_array($status_gizi, ['Underweight', 'Severely Underweight'])) {
            return 'bg-yellow-200 text-yellow-800';
        }
        // Overweight / Obesitas - ungu (agar berbeda dari yang lain)
        if (in_array($status_gizi, ['Overweight', 'Obese', 'Overweight / Obese'])) {
            return 'bg-purple-200 text-purple-800';
        }
        // Normal - hijau
        if ($status_gizi == 'Normal' && $status_stunting == 'Normal') {
            return 'bg-green-200 text-green-800';
        }
        // Default - abu-abu
        return 'bg-gray-200 text-gray-800';
    }
}