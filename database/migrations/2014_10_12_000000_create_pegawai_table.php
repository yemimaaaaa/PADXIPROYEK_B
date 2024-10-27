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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->increments('id_pegawai');
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('foto')->nullable();
            $table->string('no_hp',14)->nullable();
            $table->string('email');
            $table->unsignedBigInteger('id_role'); 
            $table->foreign('id_role')->references('id_role')->on('role')->onDelete('cascade');
            $table->timestamps();
            $table->timestamp('deleted_at')->useCurrent();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
