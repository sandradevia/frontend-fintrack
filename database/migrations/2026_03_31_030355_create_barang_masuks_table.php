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
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->references('id')->on('barang')->cascadeOnDelete();
            $table->date('tanggal_masuk');
            $table->integer('jumlah');
            $table->decimal('harga_beli', 15, 2);
            $table->string('gambar')->nullable();
            $table->enum('status', [
                'pending',
                'disetujui',
                'ditolak'
            ])->default('pending');

            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
