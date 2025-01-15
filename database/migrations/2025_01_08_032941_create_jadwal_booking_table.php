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
        Schema::create('jadwal_booking', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            // Foreign Keys
            $table->unsignedBigInteger('id_ruang');
            $table->string('kluster');
            $table->date('tanggal_start');
            $table->date('tanggal_end');
            // Foreign Key Constraint
            $table->foreign('id_ruang')->references('id')->on('ruang')->onDelete('cascade');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_booking', function (Blueprint $table) {
            $table->dropForeign(['id_ruang']);
          
        });
        Schema::dropIfExists('jadwal_booking');
    }
};
