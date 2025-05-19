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
        Schema::create('usaha_rudapaksa', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('email');
            $table->boolean('success'); // true for successful, false for failed attempts
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable(); // Info browser/device
            $table->timestamp('attempted_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
};
