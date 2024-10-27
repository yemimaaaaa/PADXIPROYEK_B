<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the migrations.
     * @return void
     */
    public function run()
    {
        if (DB::table('stok')->count() === 0)
        {
            DB::table('stok')->insert(
                [
                    'id_stok' => '7001',
                    'nama_stok' => 'Kopi Arabika',
                    'jenis_stok' => 'Biji Kopi',
                    'tanggal_masuk_stok' => Carbon::now()->subDays(10),
                    'foto_stok' => 'kopi_arabika.jpg',
                    'detail_stok' => 'Biji kopi Arabika premium.',
                    'id_pegawai' => 4001, // Sesuaikan dengan ID pegawai yang ada
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7002',
                    'nama_stok' => 'Kopi Robusta',
                    'jenis_stok' => 'Biji Kopi',
                    'tanggal_masuk_stok' => Carbon::now()->subDays(8),
                    'foto_stok' => 'kopi_robusta.jpg',
                    'detail_stok' => 'Biji kopi Robusta dengan rasa kuat.',
                    'id_pegawai' => 4001,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7003',
                    'nama_stok' => 'Susu UHT',
                    'jenis_stok' => 'Susu',
                    'tanggal_masuk_stok' => Carbon::now()->subDays(5),
                    'foto_stok' => 'susu_uht.jpg',
                    'detail_stok' => 'Susu UHT untuk campuran kopi.',
                    'id_pegawai' => 4001, // Sesuaikan dengan ID pegawai yang ada
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7004',
                    'nama_stok' => 'Gula Pasir',
                    'jenis_stok' => 'Bahan Pokok',
                    'tanggal_masuk_stok' => now(),
                    'foto_stok' => 'gula_pasir.jpg',
                    'detail_stok' => 'Gula pasir untuk manisnya kopi.',
                    'id_pegawai' => 4001,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7005',
                    'nama_stok' => 'Cangkir Keramik',
                    'jenis_stok' => 'Peralatan',
                    'tanggal_masuk_stok' => Carbon::now()->subDays(20),
                    'foto_stok' => 'cangkir_keramik.jpg',
                    'detail_stok' => 'Cangkir keramik untuk penyajian kopi.',
                    'id_pegawai' => 4010,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7006',
                    'nama_stok' => 'Syrup Vanilla',
                    'jenis_stok' => 'Bahan Campuran',
                    'tanggal_masuk_stok' => Carbon::now()->subDays(12),
                    'foto_stok' => 'syrup_vanilla.jpg',
                    'detail_stok' => 'Syrup vanilla untuk varian kopi.',
                    'id_pegawai' => 4010,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7007',
                    'nama_stok' => 'Kopi Decaf',
                    'jenis_stok' => 'Biji Kopi',
                    'tanggal_masuk_stok' => Carbon::now()->subDays(3),
                    'foto_stok' => 'kopi_decaf.jpg',
                    'detail_stok' => 'Kopi tanpa kafein untuk yang sensitif.',
                    'id_pegawai' => 4010,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7008',
                    'nama_stok' => 'Kue Brownies',
                    'jenis_stok' => 'Snack',
                    'tanggal_masuk_stok' => now(),
                    'foto_stok' => 'kue_brownies.jpg',
                    'detail_stok' => 'Brownies lezat untuk teman kopi.',
                    'id_pegawai' => 4010,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7009',
                    'nama_stok' => 'Cokelat Bubuk',
                    'jenis_stok' => 'Bahan Campuran',
                    'tanggal_masuk_stok' => Carbon::now()->subDays(14),
                    'foto_stok' => 'cokelat_bubuk.jpg',
                    'detail_stok' => 'Cokelat bubuk untuk mocha.',
                    'id_pegawai' => 4010,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
                ],
                [
                    'id_stok' => '7010',
                    'nama_stok' => 'Air Mineral',
                    'jenis_stok' => 'Minuman',
                    'tanggal_masuk_stok' => Carbon::now()->subDays(1),
                    'foto_stok' => 'air_mineral.jpg',
                    'detail_stok' => 'Air mineral untuk penyajian.',
                    'id_pegawai' =>4010,
                    // 'created_at' => Carbon::now(),
                    // 'updated_at' => Carbon::now(),
                    // 'deleted_at' => null,
            ]);
        }
    }
}
