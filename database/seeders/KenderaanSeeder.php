<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KenderaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('kenderaan')->insert([
            [
                'no_pendaftaran' => 'JJY 4381',
                'gambar_kenderaan' => 'images/kenderaan/hilux_white.jpg',
                'jenis_kenderaan' => 'Pickup Truck',
                'jenama' => 'Toyota',
                'model' => 'Hilux',
                'warna' => 'White',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2024-12-05',
                'tarikh_tamat_roadtax' => '2025-12-05',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'BKE 1002',
                'gambar_kenderaan' => 'images/kenderaan/navara_white.png',
                'jenis_kenderaan' => 'Pickup Truck',
                'jenama' => 'Nissan',
                'model' => 'Navara',
                'warna' => 'White',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2024-12-05',
                'tarikh_tamat_roadtax' => '2025-12-05',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'DEA 9673',
                'gambar_kenderaan' => 'images/kenderaan/triton_white.jpg',
                'jenis_kenderaan' => 'Pickup Truck',
                'jenama' => 'Mitsubishi',
                'model' => 'Triton',
                'warna' => 'White',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2025-05-01',
                'tarikh_tamat_roadtax' => '2026-05-01',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'MDL 9673',
                'gambar_kenderaan' => 'images/kenderaan/isuzuLorry.jpg',
                'jenis_kenderaan' => 'Lorry',
                'jenama' => 'Isuzu',
                'model' => 'Lorry',
                'warna' => 'White',
                'kapasiti_penumpang' => 2,
                'tarikh_mula_roadtax' => '2024-09-27',
                'tarikh_tamat_roadtax' => '2025-09-27',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'MDQ 9673',
                'gambar_kenderaan' => 'images/kenderaan/hiace.jpg',
                'jenis_kenderaan' => 'Van',
                'jenama' => 'Toyota',
                'model' => 'Hiace (Panel Van)',
                'warna' => 'White',
                'kapasiti_penumpang' => 10,
                'tarikh_mula_roadtax' => '2024-06-22',
                'tarikh_tamat_roadtax' => '2025-06-22',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'JQR 9673',
                'gambar_kenderaan' => 'images/kenderaan/crv_white.jpg',
                'jenis_kenderaan' => 'SUV',
                'jenama' => 'Honda',
                'model' => 'CR-V',
                'warna' => 'White',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2025-02-26',
                'tarikh_tamat_roadtax' => '2026-02-26',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'JPA 9673',
                'gambar_kenderaan' => 'images/kenderaan/hilux_silver.jpg',
                'jenis_kenderaan' => 'Pickup Truck',
                'jenama' => 'Toyota',
                'model' => 'Hilux',
                'warna' => 'Silver',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2024-12-05',
                'tarikh_tamat_roadtax' => '2025-12-05',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'JRH 9673',
                'gambar_kenderaan' => 'images/kenderaan/triton_white.jpg',
                'jenis_kenderaan' => 'Pickup Truck',
                'jenama' => 'Mitsubishi',
                'model' => 'Triton',
                'warna' => 'White',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2025-02-15',
                'tarikh_tamat_roadtax' => '2026-02-15',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'JTT 9673',
                'gambar_kenderaan' => 'images/kenderaan/triton_white.jpg',
                'jenis_kenderaan' => 'Pickup Truck',
                'jenama' => 'Mitsubishi',
                'model' => 'Triton',
                'warna' => 'White',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2024-12-05',
                'tarikh_tamat_roadtax' => '2025-12-05',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'MCT 9673',
                'gambar_kenderaan' => 'images/kenderaan/triton_silver.jpg',
                'jenis_kenderaan' => 'Pickup Truck',
                'jenama' => 'Mitsubishi',
                'model' => 'Triton',
                'warna' => 'Silver',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2025-02-09',
                'tarikh_tamat_roadtax' => '2026-02-09',
                'status_kenderaan' => 'Available',
            ],
            [
                'no_pendaftaran' => 'BKE 1059',
                'gambar_kenderaan' => 'images/kenderaan/navara_white.png',
                'jenis_kenderaan' => 'Pickup Truck',
                'jenama' => 'Nissan',
                'model' => 'Navara',
                'warna' => 'White',
                'kapasiti_penumpang' => 5,
                'tarikh_mula_roadtax' => '2024-11-28',
                'tarikh_tamat_roadtax' => '2025-11-28',
                'status_kenderaan' => 'Available',
            ],
        ]);
    }
}
