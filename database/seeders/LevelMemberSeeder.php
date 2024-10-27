<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelMemberSeeder extends seeder
{
    /**
     * Run the migrations.
     * @return void
     */
    public function run()
    {
        if (DB::table('levelmember')->count() ===0)
        {
            DB::table('levelmember')->insert([
            ['id_level_member' =>1001, 'tingkatan_level' => 'Bronze','poin_minimal' => 1,  'diskon' => 0.05,],
            ['id_level_member' =>1002,'tingkatan_level' => 'Silver','poin_minimal' => 1001,'diskon' => 0.15,],
            ['id_level_member' =>1003,'tingkatan_level' => 'Gold',  'poin_minimal' => 2001,'diskon' => 0.25,]
        ]);
            // DB::table('role')->insert([
            //     ['id_role' => 1, 'nama_role' => 'owner'],
            //     ['id_role' => 2, 'nama_role' => 'pegawai'],
            // ]);
        }
    }
}
