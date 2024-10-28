<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DetailTransaksiSeeder extends Seeder
{
    /**
     * Run the seeder.
     * @return void
     */
    public function run()
    {
        // Menangkap pengecualian jika ada masalah saat menyisipkan data
        try {
            DB::table('detailtransaksi')->insert([
                [
                    'kode_transaksi' => 6001, // Pastikan kode_transaksi ini ada di tabel transaksi
                    'id_produk' => 2001,       // Pastikan id_produk ini ada di tabel produk
                    'tanggal_penjualan' => now(),
                    'jumlah' => 2,
                    'subtotal' => 20000.0,
                ],
                [
                    'kode_transaksi' => 6002,
                    'id_produk' => 2002,
                    'tanggal_penjualan' => Carbon::now()->subDays(4),
                    'jumlah' => 1,
                    'subtotal' => 15000.0,
                ],
                [
                    'kode_transaksi' => 6003,
                    'id_produk' => 2003,
                    'tanggal_penjualan' => Carbon::now()->subDays(5),
                    'jumlah' => 3,
                    'subtotal' => 45000.0,
                ],
                [
                    'kode_transaksi' => 6004,
                    'id_produk' => 2004,
                    'tanggal_penjualan' => now(),
                    'jumlah' => 5,
                    'subtotal' => 75000.0,
                ],
                [
                    'kode_transaksi' => 6005,
                    'id_produk' => 2005,
                    'tanggal_penjualan' => Carbon::now()->subDays(6),
                    'jumlah' => 2,
                    'subtotal' => 30000.0,
                ],
                [
                    'kode_transaksi' => 6006,
                    'id_produk' => 2006,
                    'tanggal_penjualan' => Carbon::now()->subDays(5),
                    'jumlah' => 4,
                    'subtotal' => 60000.0,
                ],
                [
                    'kode_transaksi' => 6007,
                    'id_produk' => 2007,
                    'tanggal_penjualan' => Carbon::now()->subDays(4),
                    'jumlah' => 1,
                    'subtotal' => 12000.0,
                ],
                [
                    'kode_transaksi' => 6008,
                    'id_produk' => 2008,
                    'tanggal_penjualan' => Carbon::now()->subDays(3),
                    'jumlah' => 6,
                    'subtotal' => 90000.0,
                ],
                [
                    'kode_transaksi' => 6009,
                    'id_produk' => 2009,
                    'tanggal_penjualan' => Carbon::now()->subDays(2),
                    'jumlah' => 2,
                    'subtotal' => 25000.0,
                ],
                [
                    'kode_transaksi' => 6010,
                    'id_produk' => 2010,
                    'tanggal_penjualan' => now(),
                    'jumlah' => 3,
                    'subtotal' => 45000.0,
                ]
            ]);
        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan error
            echo 'Error: ' . $e->getMessage();
        }
    }
}