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
    Schema::table('stok_awal', function (Blueprint $table) {
        $table->decimal('harga_beli_awal', 15, 2)
              ->default(0)
              ->after('stok');
    });
}

public function down(): void
{
    Schema::table('stok_awal', function (Blueprint $table) {
        $table->dropColumn('harga_beli_awal');
    });
}
};
