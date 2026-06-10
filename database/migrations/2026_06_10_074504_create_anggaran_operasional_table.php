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
        Schema::create('anggaran_operasional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dapur_id')->references('id')->on('dapur')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->decimal('total_rab', 15, 2);
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
        Schema::dropIfExists('anggaran_operasional');
    }
};
