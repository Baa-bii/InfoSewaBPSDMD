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
        // Path ke file SQL
        $path = database_path('sql/ruang_asrama_bpsdmd.sql');

        // Eksekusi file SQL
        DB::unprepared(file_get_contents($path));

        $this->command->info('Data ruang berhasil diimpor dari file SQL.');
    }
}
