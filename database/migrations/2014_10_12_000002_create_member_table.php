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
            $table->id('id_member'); // Primary key
            $table->string('nama'); // Member name
            $table->string('no_hp', 14)->unique(); // Unique phone number
            $table->timestamp('periode_awal'); // Membership start period
            $table->timestamp('periode_akhir')->nullable(); // Membership end period (optional)
            $table->string('foto')->nullable(); // Optional photo

            // Foreign key to levelmember table
            $table->unsignedInteger('id_level_member'); // Match type with levelmember table
            $table->foreign('id_level_member')
                  ->references('id_level_member')
                  ->on('levelmember')
                  ->onDelete('cascade');

            $table->integer('poin')->default(0); // Points column
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at
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
