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
        Schema::create('stok_awal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')
                ->constrained('barang')
                ->cascadeOnDelete();
            $table->foreignId('dapur_id')
                ->constrained('dapur')
                ->cascadeOnDelete();
            $table->integer('jumlah');
            $table->string('gambar')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->foreignId('verified_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_awal');
    }
};
