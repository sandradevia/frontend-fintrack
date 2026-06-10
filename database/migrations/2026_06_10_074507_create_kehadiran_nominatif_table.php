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
        Schema::create('kehadiran_nominatif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daftar_nominatif_id')->constrained('daftar_nominatif')->cascadeOnDelete();
            $table->date('tanggal');
            $table->decimal('honor_harian', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran_nominatif');
    }
};
