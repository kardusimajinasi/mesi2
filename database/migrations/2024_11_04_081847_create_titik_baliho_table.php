<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('titik_baliho', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Kolom ID sebagai UUID
            $table->string('nama_baliho'); // Kolom nama baliho
            $table->string('lokasi_baliho'); // Kolom lokasi baliho
            $table->string('kordinat_baliho'); // Kolom koordinat baliho
            $table->string('foto_baliho')->nullable(); // Kolom foto baliho, bisa nullable
            $table->string('ukuran_baliho'); // Kolom ukuran baliho
            $table->string('layout_baliho'); // Kolom layout baliho
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_baliho');
    }
};
