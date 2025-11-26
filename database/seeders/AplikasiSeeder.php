<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aplikasi;

class AplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aplikasiList = [
            [
                'inisial' => 'Nadine',
                'nama' => 'Nadine - Aplikasi Pengelolaan Data',
                'is_active' => true,
            ],
            [
                'inisial' => 'DFarm',
                'nama' => 'DFarm - Digital Farming System',
                'is_active' => true,
            ],
            [
                'inisial' => 'HRIS',
                'nama' => 'HRIS - Human Resource Information System',
                'is_active' => true,
            ],
            [
                'inisial' => 'ARHAN',
                'nama' => 'ARHAN - Arsip Handal',
                'is_active' => true,
            ],
            [
                'inisial' => 'MONIKA',
                'nama' => 'MONIKA - Monitoring Kinerja',
                'is_active' => true,
            ],
            [
                'inisial' => 'MAIA',
                'nama' => 'MAIA - Management Aplikasi Internal',
                'is_active' => true,
            ],
            [
                'inisial' => 'StakeHolder',
                'nama' => 'StakeHolder - Portal Stakeholder',
                'is_active' => true,
            ],
            [
                'inisial' => 'Lainnya',
                'nama' => 'Lainnya - Aplikasi Lainnya',
                'is_active' => true,
            ],
        ];

        foreach ($aplikasiList as $aplikasi) {
            Aplikasi::create($aplikasi);
        }
    }
}
