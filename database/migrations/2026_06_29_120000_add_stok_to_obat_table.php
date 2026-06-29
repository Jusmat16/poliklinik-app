<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tambah kolom `stok` ke tabel `obat` untuk fitur manajemen stok.
     * Default 0 artinya obat yang belum diisi stok-nya dianggap habis
     * (pengaman agar tidak ada stok phantom yang bisa diretas).
     */
    public function up(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->integer('stok')->default(0)->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropColumn('stok');
        });
    }
};