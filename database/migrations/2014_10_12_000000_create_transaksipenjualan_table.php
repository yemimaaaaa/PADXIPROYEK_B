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
        Schema::create('transaksipenjualan', function (Blueprint $table) {
            $table->increments('kode_transaksi');
            $table->timestamp('tanggal_penjualan');
            $table->float('nominal_uang_diterima', 10,2);
            $table->float('nominal_uang_kembalian', 10,2);
            $table->float('total', 10,2)->nullable();
            $table->enum('payment_method', ['cash', 'debit', 'e-wallet']);
            $table->unsignedBigInteger('id_pegawai'); 
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai');
            $table->unsignedBigInteger('id_member')->nullable(); // Pastikan nullable diterapkan di sini
            $table->foreign('id_member')->references('id_member')->on('member');     
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksipenjualan');
    }
};
