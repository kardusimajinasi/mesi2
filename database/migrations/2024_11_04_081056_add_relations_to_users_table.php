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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom foreign key level_user jika belum ada
            if (!Schema::hasColumn('users', 'level')) {
                $table->uuid('level')->nullable()->after('name');
            }

            // Menambahkan kolom foreign key level jika belum ada
            if (!Schema::hasColumn('users', 'level')) {
                $table->uuid('level')->nullable()->after('level');
            }

            // Menambahkan foreign key ke tabel tbl_lvl dan tbl_level
            $table->foreign('level')->references('id')->on('tbl_lvl')->onDelete('set null');
            $table->foreign('level')->references('id')->on('tbl_level')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus foreign key dan kolom yang ditambahkan
            $table->dropForeign(['level']);
            $table->dropForeign(['level']);
            $table->dropColumn(['level', 'level']);
        });
    }
};
