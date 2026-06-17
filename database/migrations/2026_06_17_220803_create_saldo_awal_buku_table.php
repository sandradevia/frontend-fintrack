<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saldo_awal_buku', function (Blueprint $table) {
        $table->id();
        $table->foreignId('periode_id')->constrained('periode')->onDelete('cascade');
        $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
        $table->decimal('saldo_awal', 15, 2)->default(0);
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldo_awal_buku');
    }
};