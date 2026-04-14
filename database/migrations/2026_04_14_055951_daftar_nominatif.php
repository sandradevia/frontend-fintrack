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
        Schema::create('daftar_nominatif', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dapur_id')->references('id')->on('dapur')->cascadeOnDelete();
            $table->foreignId('anggota_id')->references('id')->on('anggota')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('no_bukti');
            $table->decimal('honor', 15, 2)->default(0);
            $table->decimal('dana_sehat', 15, 2)->default(0);
            $table->decimal('transport', 15, 2)->default(0);
            $table->decimal('pajak', 15, 2)->default(0);

            $table->decimal('total', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_nominatif');
    }
};
