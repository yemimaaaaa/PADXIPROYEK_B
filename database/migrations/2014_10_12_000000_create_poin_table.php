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
        Schema::create('poin', function (Blueprint $table) {
            $table->increments('id_poin');
            $table->timestamp('tanggal');
            $table->integer('total_poin');
            $table->unsignedBigInteger('kode_transaksi'); 
            $table->foreign('kode_transaksi')->references('kode_transaksi')->on('kode_transaksi')->onDelete('cascade');
            $table->unsignedBigInteger('id_member'); 
            $table->foreign('id_member')->references('id_member')->on('member')->onDelete('cascade');
            $table->timestamps('updated_at');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin');
    }
};
