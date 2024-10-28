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
        Schema::create('detailtransaksi', function (Blueprint $table) {
            $table->integer('id_detail_transaksi')->primary()->autoincrement();
            $table->datetime('tanggal_penjualan')->notNull();
            $table->integer('jumlah')->notNull();
            $table->float('subtotal')->notNull();
            $table->unsignedBigInteger('kode_transaksi'); 
            $table->foreign('kode_transaksi')->references('kode_transaksi')->on('transaksipenjualan')->onDelete('cascade');
            $table->unsignedBigInteger('id_produk'); 
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailtransaksi');
    }
};
