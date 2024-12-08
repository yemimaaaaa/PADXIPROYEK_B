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
            $table->increments('id_detail_transaksi'); // Primary key
            $table->unsignedInteger('kode_transaksi'); // Match type with transaksipenjualan table
            $table->foreign('kode_transaksi')
                  ->references('kode_transaksi')
                  ->on('transaksipenjualan')
                  ->onDelete('cascade'); // Cascade on delete
            
            $table->unsignedInteger('id_produk'); // Foreign key to produk table
            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->onDelete('cascade');
            
            $table->integer('jumlah'); // Quantity of the product
            $table->float('subtotal', 10, 2); // Subtotal for the transaction
            
            $table->timestamp('tanggal_penjualan'); // Add this column

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
