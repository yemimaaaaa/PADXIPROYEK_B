<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the migrations.
     * @return void
     */
    public function run()
    {
        if (DB::table('role')->count() ===0)
        {
            DB::table('role')->insert([
                ['id_role' => 10101, 'nama_role' => 'owner'],
                ['id_role' => 10102, 'nama_role' => 'pegawai'],
            ]);
        }
    }
}
