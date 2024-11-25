<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    public function showLandingPage()
    {
        try {
            // Ambil 10 produk terlaris berdasarkan jumlah penjualan
            $produks = DB::table('detailtransaksi')
                ->join('produk', 'detailtransaksi.id_produk', '=', 'produk.id_produk')
                ->join('transaksipenjualan', 'detailtransaksi.kode_transaksi', '=', 'transaksipenjualan.kode_transaksi')
                ->select('produk.nama_produk', 'produk.deskripsi_produk', 'produk.foto_produk', 'produk.harga')
                ->selectRaw('SUM(detailtransaksi.jumlah) as jumlah_terjual')
                ->whereMonth('transaksipenjualan.tanggal_penjualan', date('m')) // Filter untuk bulan ini
                ->groupBy('produk.id_produk')
                ->orderBy('jumlah_terjual', 'desc')
                ->limit(10)
                ->get();

            // Log data jika ada
            if ($produks->isEmpty()) {
                Log::warning('Tidak ada produk yang ditemukan untuk bulan ini.');
            } else {
                Log::info('Produk terlaris berhasil diambil.', ['produk' => $produks->toArray()]);
            }

            // Pastikan path foto produk lengkap
            $produks->transform(function ($produk) {
                $produk->foto_produk = $produk->foto_produk && !str_starts_with($produk->foto_produk, 'uploads/')
                    ? 'uploads/' . $produk->foto_produk
                    : $produk->foto_produk;
                return $produk;
            });

            // Kirim data ke view
            return view('landingpage', compact('produks'));
        } catch (\Exception $e) {
            // Log error jika terjadi kesalahan
            Log::error('Kesalahan saat mengambil produk terlaris:', ['error' => $e->getMessage()]);
            return view('landingpage', ['produks' => collect([])])
                ->with('error', 'Terjadi kesalahan saat memuat data produk.');
        }
    }
}
