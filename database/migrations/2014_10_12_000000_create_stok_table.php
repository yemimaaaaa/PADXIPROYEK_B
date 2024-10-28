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
        Schema::create('stok', function (Blueprint $table) {
            $table->increments('id_stok');
            $table->string('nama_stok');
            $table->string('jenis_stok');
            $table->timestamp('tanggal_masuk_stok');
            $table->string('foto_stok')->nullable(); // Menyimpan path foto stok
            $table->string('detail_stok')->nullable();
            $table->unsignedBigInteger('id_pegawai'); 
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
