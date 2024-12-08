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
            // Primary key
            $table->increments('id_stok');

            // Stok details
            $table->string('nama_stok'); // Name of the stock item
            $table->string('jenis_stok'); // Type of the stock
            $table->timestamp('tanggal_masuk_stok'); // Stock entry date
            $table->string('foto_stok')->nullable(); // Optional photo path
            $table->string('detail_stok')->nullable(); // Optional details

            // Foreign key to pegawai table
            $table->unsignedInteger('id_pegawai'); // Match type with pegawai table
            $table->foreign('id_pegawai')
                  ->references('id_pegawai')
                  ->on('pegawai')
                  ->onDelete('cascade');

            // Timestamps and soft deletes
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // Adds deleted_at column
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
