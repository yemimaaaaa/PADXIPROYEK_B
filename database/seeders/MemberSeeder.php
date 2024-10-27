<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberSeeder extends Seeder
{
    /**
     * Run the migrations.
     * @return void
     */
    public function run()
    {
        if (DB::table('member')->count() === 0)
        {
            DB::table('member')->insert([
                [
                    'id_member' => 3001, 
                    'nama' => 'John Doe', 
                    'no_hp' => '081234567890', 
                    'periode_awal' => Carbon::now()->subMonths(6), 
                    'periode_akhir' => now(), 
                    'foto' => 'john_doe.jpg', 
                    'id_level_member' => 1001
                ],
                [
                    'id_member' => 3002, 
                    'nama' => 'Jane Smith', 
                    'no_hp' => '081234567891', 
                    'periode_awal' => Carbon::now()->subMonths(6), 
                    'periode_akhir' => now(), 
                    'foto' => 'jane_smith.jpg', 
                    'id_level_member' => 1002
                ],
                [
                    'id_member' => 3003, 
                    'nama' => 'Michael Brown', 
                    'no_hp' => '081234567892', 
                    'periode_awal' => Carbon::now()->subMonths(6), 
                    'periode_akhir' => now(), 
                    'foto' => 'michael_brown.jpg', 
                    'id_level_member' => 1003
                ],
                [
                    'id_member' => 3004, 
                    'nama' => 'Emily Davis', 
                    'no_hp' => '081234567893', 
                    'periode_awal' => Carbon::now()->subMonths(6), 
                    'periode_akhir' => now(), 
                    'foto' => 'emily_davis.jpg', 
                    'id_level_member' => 1001
                ],
                [
                    'id_member' => 3005, 
                    'nama' => 'Sarah Wilson', 
                    'no_hp' => '081234567894', 
                    'periode_awal' => Carbon::now()->subMonths(6), 
                    'periode_akhir' => now(), 
                    'foto' => 'sarah_wilson.jpg', 
                    'id_level_member' => 1002
                ],
                [
                    'id_member' => 3006, 
                    'nama' => 'David Lee', 
                    'no_hp' => '081234567895', 
                    'periode_awal' => Carbon::now()->subMonths(6), 
                    'periode_akhir' => now(), 
                    'foto' => 'david_lee.jpg', 
                    'id_level_member' => 1001
                ],
                [
                    'id_member' => 3007, 
                    'nama' => 'Zhou Guanyu', 
                    'no_hp' => '081234567896', 
                    'periode_awal' => Carbon::now()->subMonths(2), 
                    'periode_akhir' => Carbon::now()->addMonths(5), 
                    'foto' => 'zhou_guanyu.jpg', 
                    'id_level_member' => 1003
                ],
                [
                    'id_member' => 3008, 
                    'nama' => 'Fernando Alonso', 
                    'no_hp' => '081234567897', 
                    'periode_awal' => Carbon::now()->subMonths(6), 
                    'periode_akhir' => now(), 
                    'foto' => 'fernando_alonso.jpg', 
                    'id_level_member' => 1001
                ],
                [
                    'id_member' => 3009, 
                    'nama' => 'Lando Norris', 
                    'no_hp' => '081234567898', 
                    'periode_awal' => Carbon::now()->subMonths(6), 
                    'periode_akhir' => now(), 
                    'foto' => 'lando_norris.jpg', 
                    'id_level_member' => 1002
                ],
                [
                    'id_member' => 3010, 
                    'nama' => 'Max Delose', 
                    'no_hp' => '081234567899', 
                    'periode_awal' => Carbon::now()->subMonths(2), 
                    'periode_akhir' => Carbon::now()->addMonths(5), 
                    'foto' => 'max_delose.jpg', 
                    'id_level_member' => 1003
                ]
            ]);
        }
    }
}
