<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PoinSeeder extends Seeder
{
    /**
     * Run the seeder.
     * @return void
     */
    public function run()
    {
        if (DB::table('poin')->count() === 0) {
            DB::table('poin')->insert([
                [
                    'tanggal' => now(),
                    'total_poin' => 10,
                    'kode_transaksi' => 6001, 
                    'id_member' => 3001       
                ],
                [
                    'tanggal' => Carbon::now()->subDays(7),
                    'total_poin' => 200,
                    'kode_transaksi' => 6002, 
                    'id_member' => 3002       
                ],
                [
                    'tanggal' => Carbon::now()->subDays(8),
                    'total_poin' => 90,
                    'kode_transaksi' => 6003,
                    'id_member' => 3003       
                ],
                [
                    'tanggal' => Carbon::now()->subDays(7),
                    'total_poin' => 35,
                    'kode_transaksi' => 6004, 
                    'id_member' => 3004       
                ],
                [
                    'tanggal' => Carbon::now()->subDays(6),
                    'total_poin' => 65,
                    'kode_transaksi' => 6005, 
                    'id_member' => 3005       
                ],
                [
                    'tanggal' => now(),
                    'total_poin' => 160,
                    'kode_transaksi' => 6006, 
                    'id_member' => 3006       
                ],
                [
                    'tanggal' => Carbon::now()->subDays(4),
                    'total_poin' => 170,
                    'kode_transaksi' => 6007, 
                    'id_member' => 3007       
                ],
                [
                    'tanggal' => Carbon::now()->subDays(3),
                    'total_poin' => 180,
                    'kode_transaksi' => 6008, 
                    'id_member' => 3008       
                ],
                [
                    'tanggal' => Carbon::now()->subDays(2),
                    'total_poin' => 190,
                    'kode_transaksi' => 6009, 
                    'id_member' => 3009       
                ],
                [
                    'tanggal' => Carbon::now()->subDays(1),
                    'total_poin' => 300,
                    'kode_transaksi' => 6010, 
                    'id_member' => 3010       
                ]
            ]);
        }
    }
}

