<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('anggaran_bahan', function (Blueprint $table) {
            // Menambahkan kolom harga kedua setelah kolom harga_satuan lama
            $table->decimal('harga_satuan_2', 15, 2)->nullable()->after('harga_satuan');
        });
    }

    public function down()
    {
        Schema::table('anggaran_bahan', function (Blueprint $table) {
            $table->dropColumn('harga_satuan_2');
        });
    }
};
