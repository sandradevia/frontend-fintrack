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
        Schema::create('detail_anggaran_bahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggaran_bahan_id')->references('id')->on('anggaran_bahan')->cascadeOnDelete();
            $table->foreignId('kategori_penerima_id')->references('id')->on('kategori_penerima')->cascadeOnDelete();
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_anggaran_bahan');
    }
};
