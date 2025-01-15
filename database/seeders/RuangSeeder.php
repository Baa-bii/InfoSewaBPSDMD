<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table ('ruang')->insert([
            [
                'nama_ruang' => '101',
                'kluster' => 'Sindoro I',
                'kapasitas' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ruang' => '102',
                'kluster' => 'Sindoro I',
                'kapasitas' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_ruang' => '103',
                'kluster' => 'Sindoro I',
                'kapasitas' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
