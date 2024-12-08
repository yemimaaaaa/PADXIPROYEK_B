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
        Schema::create('levelmember', function (Blueprint $table) {
            $table->unsignedInteger('id_level_member')->autoIncrement(); // Match type with 'member' table
            $table->string('tingkatan_level');
            $table->integer('poin_minimal'); // Points required to reach this level
            $table->decimal('diskon', 5, 2)->nullable(); // Discount for this level
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levelmember');
    }
};
