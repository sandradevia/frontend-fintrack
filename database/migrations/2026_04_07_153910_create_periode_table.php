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
        Schema::create('periode', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dapur_id')->references('id')->on('dapur')->cascadeOnDelete();
            $table->year('tahun_anggaran');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_pelaporan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
