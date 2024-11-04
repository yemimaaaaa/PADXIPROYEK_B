<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the migrations.
     * @return void
     */
    public function run()
    {
        
    if (DB::table('pegawai')->count() === 0)
    {
        // Memastikan bahwa role yang dimasukkan sudah ada
        $validRoles = DB::table('role')->pluck('id_role')->toArray();

        DB::table('pegawai')->insert([
            [
                'id_pegawai' => 4001,
                'nama' => 'Alice Johnson',
                'username' => 'pegawai1',
                'password' => Hash::make('password123'),
                'foto' => 'pegawaii.jpg',
                'no_hp' => '081234567800',
                'email' => 'alice@example.com',
                'id_role' => in_array(10101, $validRoles) ? '10101' : null, // Validasi role
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id_pegawai' => 4010,
                'nama' => 'Jack King',
                'username' => 'pegawai2',
                'password' => Hash::make('password123'),
                'foto' => 'pegawaibisayok.jpeg',
                'no_hp' => '081234567809',
                'email' => 'jack@example.com',
                'id_role' => in_array(10102, $validRoles) ? '10102' : null, // Validasi role
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        ]);
    }
   }
}