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
        Schema::table('tbl_pesan', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->after('level_id');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
            $table->text('keterangan_event')->nullable()->after('tanggal_selesai');
            $table->string('upload_surat')->nullable()->after('keterangan_event');
            $table->string('no_surat')->nullable()->after('upload_surat');
            $table->date('tgl_surat')->nullable()->after('no_surat');
            $table->string('perihal_surat')->nullable()->after('tgl_surat');
            $table->string('upload_desain')->nullable()->after('perihal_surat');
            $table->string('upload_lepas_baliho')->nullable()->after('upload_desain');
            $table->string('nama_pic')->nullable()->after('upload_lepas_baliho');
            $table->string('tlp_pic')->nullable()->after('nama_pic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_pesan', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_mulai',
                'tanggal_selesai',
                'keterangan_event',
                'upload_surat',
                'no_surat',
                'tgl_surat',
                'perihal_surat',
                'upload_desain',
                'upload_lepas_baliho',
                'nama_pic',
                'tlp_pic',
            ]);
        });
    }
};
