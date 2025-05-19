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
            $table->id();
            $table->char('baliho_id')->nullable();
            $table->char('user_id')->nullable();
            $table->char('instansi_id')->nullable();
            $table->char('level_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('baliho_id')->references('id')->on('tbL_baliho')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('instansi_id')->references('id')->on('tbl_instansi')->onDelete('set null');
            $table->foreign('level_id')->references('id')->on('tbl_lvl')->onDelete('set null');
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
