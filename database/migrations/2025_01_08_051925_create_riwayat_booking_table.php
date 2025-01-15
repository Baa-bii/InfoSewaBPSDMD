<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jadwal');
            $table->string('nama_pemesan');
            $table->string('nama_ruang');
            $table->string('kluster');
            $table->date('tanggal_start');
            $table->date('tanggal_end');
            $table->foreign('id_jadwal')->references('id')->on('jadwal_booking')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_booking', function (Blueprint $table) {
            $table->dropForeign(['id_jadwal']);
          
        });
        Schema::dropIfExists('riwayat_booking');
    }
};
