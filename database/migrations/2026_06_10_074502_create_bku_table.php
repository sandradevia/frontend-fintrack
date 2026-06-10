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
        Schema::create('bku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dapur_id')->references('id')->on('dapur')->cascadeOnDelete();
            $table->foreignId('transaksi_id')->references('id')->on('transaksi')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('no_bukti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bku');
    }
};
