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
        Schema::table('tbl_baliho', function (Blueprint $table) {
            $table->dropColumn('koordinat_baliho');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_baliho', function (Blueprint $table) {
            $table->string('koordinat_baliho')->nullable();
        });
    }
};
