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
            $table->increments('kode_transaksi'); // Primary key
            $table->timestamp('tanggal_penjualan');
            $table->float('nominal_uang_diterima', 10, 2);
            $table->float('nominal_uang_kembalian', 10, 2);
            $table->float('total', 10, 2)->nullable();
            $table->enum('payment_method', ['cash', 'debit', 'e-wallet']);
            
            // Match id_pegawai with pegawai table
            $table->unsignedInteger('id_pegawai'); 
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('cascade');
            
            // Match id_member with member table
            $table->unsignedBigInteger('id_member')->nullable(); // Match type with member table
            $table->foreign('id_member')->references('id_member')->on('member')->onDelete('cascade');

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
