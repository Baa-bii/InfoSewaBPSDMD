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
        Schema::create('ruang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruang');
            $table->string('kluster');
            $table->string('gedung')->nullable();
            $table->integer('harga');
            $table->boolean('booking_status')->default(false);
            $table->boolean('validate_status')->default(false);
            $table->integer('kapasitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     
        Schema::table('ruang', function (Blueprint $table) {
            $table->dropForeign(['kode_kluster']);
          
        });
        Schema::dropIfExists('ruang');
    }
};
