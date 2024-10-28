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
        Schema::create('member', function (Blueprint $table) {
            $table->id('id_member');
            $table->string('nama');
            $table->string('no_hp',14)->unique();
            $table->timestamp('periode_awal');
            $table->timestamp('periode_akhir')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_level_member'); 
            $table->foreign('id_level_member')->references('id_level_member')->on('levelmember')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
