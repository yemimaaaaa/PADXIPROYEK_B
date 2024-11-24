<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    public function showLandingPage()
    {
        try {
            // Query untuk mengambil 10 produk terlaris
            $produks = DetailTransaksi::join('produk', 'detailtransaksi.id_produk', '=', 'produk.id_produk')
                ->join('transaksipenjualan', 'detailtransaksi.kode_transaksi', '=', 'transaksipenjualan.kode_transaksi')
                ->selectRaw('produk.id_produk, produk.nama_produk, produk.foto_produk, produk.harga, produk.deskripsi_produk, SUM(detailtransaksi.jumlah) as total_terjual')
                ->groupBy('produk.id_produk', 'produk.nama_produk', 'produk.foto_produk', 'produk.harga', 'produk.deskripsi_produk')
                ->orderByDesc('total_terjual')
                ->limit(10)
                ->get();

            // Debugging log
            if ($produks->isEmpty()) {
                Log::warning('Produk tidak ditemukan.', ['query' => $produks]);
                return view('landing', ['produks' => []])
                    ->with('error', 'Tidak ada produk yang ditemukan.');
            }

            Log::info('Produk ditemukan.', ['produks' => $produks]);

            return view('landing', ['produks' => $produks]);
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat mengambil data produk.', ['error' => $e->getMessage()]);
            return view('landing', ['produks' => []])
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
