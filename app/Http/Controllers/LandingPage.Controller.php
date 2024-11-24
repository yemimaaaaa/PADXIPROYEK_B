<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
    
    class LandingPageController extends Controller
    {
        public function showLandingPage()
        {
            try {
                // Query untuk produk terlaris
                $produks = DB::table('detailtransaksi')
                    ->join('produk', 'detailtransaksi.id_produk', '=', 'produk.id_produk')
                    ->select(
                        'produk.id_produk',
                        'produk.nama_produk',
                        'produk.foto_produk',
                        'produk.harga',
                        'produk.deskripsi_produk',
                        DB::raw('SUM(detailtransaksi.jumlah) as total_terjual')
                    )
                    ->groupBy(
                        'produk.id_produk',
                        'produk.nama_produk',
                        'produk.foto_produk',
                        'produk.harga',
                        'produk.deskripsi_produk'
                    )
                    ->orderByDesc('total_terjual')
                    ->limit(10)
                    ->get();
    
                // Log untuk debugging
                Log::info('Hasil query produk terlaris:', ['produks' => $produks]);
    
                return view('landing', ['produks' => $produks]);
            } catch (\Exception $e) {
                Log::error('Kesalahan saat mengambil data produk:', ['error' => $e->getMessage()]);
                return view('landing')->with('error', 'Terjadi kesalahan saat memuat data.');
            }
        }
}

