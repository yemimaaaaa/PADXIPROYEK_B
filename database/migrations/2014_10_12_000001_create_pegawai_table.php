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
            // Primary key
            $table->increments('id_pegawai');

            // Employee details
            $table->string('nama'); // Full name
            $table->string('username')->unique(); // Unique username
            $table->string('password'); // Encrypted password
            $table->string('foto')->nullable(); // Profile photo (optional)
            $table->string('no_hp', 14)->nullable(); // Phone number (optional)
            $table->string('email')->unique(); // Unique email

            // Foreign key to role table
            $table->unsignedInteger('id_role');
            $table->foreign('id_role')
                  ->references('id_role')
                  ->on('role')
                  ->onDelete('cascade'); // Delete employee if role is deleted

            // Timestamps and soft deletes
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at (soft delete)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop table
        Schema::dropIfExists('pegawai');
    }
};
