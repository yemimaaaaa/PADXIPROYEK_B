<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (DB::table('transaksipenjualan')->count() === 0)
        {
            DB::table('transaksipenjualan')->insert([
                [
                    'kode_transaksi' => 6001,
                    'tanggal_penjualan' => Carbon::now()->subDays(2),
                    'nominal_uang_diterima' => 50000.00,
                    'nominal_uang_kembalian' => 10000.00,
                    'subtotal' => 40000.00,
                    'payment_method' => 'cash',
                    'id_pegawai' => 4001,
                    'id_member' => 3001,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6002,
                    'tanggal_penjualan' => Carbon::now()->subDays(9),
                    'nominal_uang_diterima' => 75000.00,
                    'nominal_uang_kembalian' => 5000.00,
                    'subtotal' => 70000.00,
                    'payment_method' => 'debit',
                    'id_pegawai' => 4001,
                    'id_member' => 3002,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6003,
                    'tanggal_penjualan' => Carbon::now()->subDays(8),
                    'nominal_uang_diterima' => 100000.00,
                    'nominal_uang_kembalian' => 20000.00,
                    'subtotal' => 80000.00,
                    'payment_method' => 'e-wallet',
                    'id_pegawai' => 4001,
                    'id_member' => 3003,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6004,
                    'tanggal_penjualan' => Carbon::now()->subDays(1),
                    'nominal_uang_diterima' => 50000.00,
                    'nominal_uang_kembalian' => 5000.00,
                    'subtotal' => 45000.00,
                    'payment_method' => 'cash',
                    'id_pegawai' => 4001,
                    'id_member' => 3004,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6005,
                    'tanggal_penjualan' => now(),
                    'nominal_uang_diterima' => 150000.00,
                    'nominal_uang_kembalian' => 10000.00,
                    'subtotal' => 140000.00,
                    'payment_method' => 'debit',
                    'id_pegawai' => 4010,
                    'id_member' => 3005,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6006,
                    'tanggal_penjualan' => now(),
                    'nominal_uang_diterima' => 60000.00,
                    'nominal_uang_kembalian' => 5000.00,
                    'subtotal' => 55000.00,
                    'payment_method' => 'e-wallet',
                    'id_pegawai' => 4010,
                    'id_member' => 3006,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6007,
                    'tanggal_penjualan' => Carbon::now()->subDays(4),
                    'nominal_uang_diterima' => 85000.00,
                    'nominal_uang_kembalian' => 15000.00,
                    'subtotal' => 70000.00,
                    'payment_method' => 'cash',
                    'id_pegawai' => 4010,
                    'id_member' => 3007,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6008,
                    'tanggal_penjualan' => Carbon::now()->subDays(3),
                    'nominal_uang_diterima' => 120000.00,
                    'nominal_uang_kembalian' => 20000.00,
                    'subtotal' => 100000.00,
                    'payment_method' => 'debit',
                    'id_pegawai' => 4010,
                    'id_member' => 3008,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6009,
                    'tanggal_penjualan' => Carbon::now()->subDays(2),
                    'nominal_uang_diterima' => 95000.00,
                    'nominal_uang_kembalian' => 5000.00,
                    'subtotal' => 90000.00,
                    'payment_method' => 'e-wallet',
                    'id_pegawai' => 4010,
                    'id_member' => 3009,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
                [
                    'kode_transaksi' => 6010,
                    'tanggal_penjualan' => Carbon::now()->subDay(),
                    'nominal_uang_diterima' => 70000.00,
                    'nominal_uang_kembalian' => 0.00,
                    'subtotal' => 70000.00,
                    'payment_method' => 'cash',
                    'id_pegawai' => 4010,
                    'id_member' => 3010,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ],
            ]);
        }
    }
}
