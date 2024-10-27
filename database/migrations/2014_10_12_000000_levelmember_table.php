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
            $table->increments('id_level_member'); // Menggunakan string untuk nama kolom
            $table->string('tingkatan_level');
            $table->integer('poin_minimal'); // Poin yang diperlukan untuk mencapai level ini
            $table->decimal('diskon', 5, 2)->nullable(); // Manfaat/hadiah yang diperoleh pada level ini
            $table->timestamps();
        });

        // Menambahkan data level member default (Bronze, Silver, Gold)
        // DB::table('levelmember')->insert([
        //     [
        //         'tingkatan_level' => 'Bronze','poin_minimal' => 10,'diskon' => 0.05,
        //     ],
        //     [
        //         'tingkatan_level' => 'Silver','poin_minimal' => 1001,'diskon' => 0.15,
        //     ],
        //     [
        //         'tingkatan_level' => 'Gold','poin_minimal' => 2001,'diskon' => 0.30,
        //     ]
        // ]);
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levelmember');
    }
};
