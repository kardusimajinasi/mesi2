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
        Schema::create('tbl_detail_pesan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tgl_mulai_event');
            $table->date('tgl_selesai_event');
            $table->string('keterangan_event');
            $table->string('foto_event');
            $table->string('surat_event');
            $table->string('nama_pic_event');
            $table->string('telp_pic_event');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_detail_pesan');
    }
};
