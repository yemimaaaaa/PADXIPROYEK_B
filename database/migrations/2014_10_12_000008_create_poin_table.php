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
            // Primary key
            $table->increments('id_poin');

            // Other columns
            $table->timestamp('tanggal'); // Date of the point entry
            $table->integer('total_poin'); // Total points

            // Foreign key to transaksipenjualan
            $table->unsignedInteger('kode_transaksi'); // Match type with transaksipenjualan
            $table->foreign('kode_transaksi')
                  ->references('kode_transaksi')
                  ->on('transaksipenjualan')
                  ->onDelete('cascade');

            // Foreign key to member
            $table->unsignedBigInteger('id_member'); // Match type with member table
            $table->foreign('id_member')
                  ->references('id_member')
                  ->on('member')
                  ->onDelete('cascade');

            // Timestamps for created_at and updated_at
            $table->timestamps();
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
