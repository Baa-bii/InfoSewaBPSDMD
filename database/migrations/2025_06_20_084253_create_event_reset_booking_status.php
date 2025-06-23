<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        DB::unprepared('
            CREATE EVENT IF NOT EXISTS reset_booking_status
            ON SCHEDULE EVERY 1 DAY
            STARTS CURRENT_DATE + INTERVAL 1 DAY
            DO
            BEGIN
                UPDATE ruang
                SET booking_status = 0
                WHERE id IN (
                    SELECT id_ruang
                    FROM jadwal_booking
                    WHERE tanggal_end < CURDATE()
                );
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP EVENT IF EXISTS reset_booking_status');
    }
};
