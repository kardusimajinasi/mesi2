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
        Schema::table('tbl_detail_pesan', function (Blueprint $table) {
            $table->string('lokasi_baliho_yg_dipesan')->after('tgl_selesai_event');
            $table->integer('jml_baliho_yg_dipesan')->after('lokasi_baliho_yg_dipesan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
