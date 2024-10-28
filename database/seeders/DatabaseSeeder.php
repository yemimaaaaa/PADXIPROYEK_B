<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(RoleSeeder::Class);
        $this->call(LevelMemberSeeder::Class);
        $this->call(MemberSeeder::Class);
        $this->call(PegawaiSeeder::Class);
        $this->call(ProdukSeeder::Class);
        $this->call(StokSeeder::Class);
        $this->call(TransaksiPenjualanSeeder::Class);
        $this->call(DetailTransaksiSeeder::Class);
        $this->call(PoinSeeder::Class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
