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
        Schema::create('tbl_pesan', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('baliho_id', 36);
            $table->char('user_id', 36);
            $table->char('instansi_id', 36);
            $table->char('level_id', 36);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('baliho_id')->references('id')->on('tbl_baliho')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('tbl_lvl')->onDelete('cascade');
            $table->foreign('instansi_id')->references('id')->on('tbl_instansi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pesan');
    }
};
