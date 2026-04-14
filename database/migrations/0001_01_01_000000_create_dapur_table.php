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
        Schema::create('dapur', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lembaga');
            $table->text('alamat')->nullable();
            $table->string('nama_kepala_sppg')->nullable();
            $table->string('nama_akuntan')->nullable();
            $table->string('nama_yayasan')->nullable();
            $table->string('ketua_yayasan')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('tempat_pelaporan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dapur');
    }
};
