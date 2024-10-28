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
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id_produk'); // Primary Key
            $table->string('nama_produk'); // Nama produk
            $table->string('jenis_produk'); // Jenis produk
            $table->float('harga', 10, 2); // Harga produk
            $table->string('deskripsi_produk')->nullable(); // Deskripsi produk
            $table->string('foto_produk')->nullable(); // Path foto produk
            $table->timestamps(); // Tanggal created_at dan updated_at
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
