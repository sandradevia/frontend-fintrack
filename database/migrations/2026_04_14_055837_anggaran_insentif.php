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
        Schema::create('anggaran_insentif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dapur_id')->references('id')->on('dapur')->cascadeOnDelete();
            $table->foreignId('anggaran_bahan_id')->references('id')->on('anggaran_bahan')->cascadeOnDelete();
            $table->date('tanggal');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_rab', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_insentif');
    }
};
