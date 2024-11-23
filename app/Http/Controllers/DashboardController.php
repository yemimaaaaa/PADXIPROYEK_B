<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\Produk;
use App\Models\Member;
use App\Models\DetailTransaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // Deteksi database yang digunakan
        $databaseConnection = config('database.default');
    
        // Data transaksi bulanan
        if ($databaseConnection === 'sqlite') {
            $monthlyTransactions = TransaksiPenjualan::selectRaw("strftime('%m', tanggal_penjualan) as month, SUM(total) as total")
                ->groupByRaw("strftime('%m', tanggal_penjualan)")
                ->orderByRaw("strftime('%m', tanggal_penjualan)")
                ->get();
        } else {
            $monthlyTransactions = TransaksiPenjualan::selectRaw('MONTH(tanggal_penjualan) as month, SUM(total) as total')
                ->groupByRaw('MONTH(tanggal_penjualan)')
                ->orderBy('month')
                ->get();
        }
    
        // Transformasi data transaksi bulanan
        $monthlyData = $monthlyTransactions->mapWithKeys(function ($item) {
            return [(int) $item->month => $item->total];
        });
    
        // Data pegawai yang mengelola transaksi
        $pegawaiTransactions = TransaksiPenjualan::join('pegawai', 'transaksipenjualan.id_pegawai', '=', 'pegawai.id_pegawai') // Ubah 'pegawai.id' menjadi 'pegawai.id_pegawai'
            ->selectRaw('pegawai.nama as pegawai_name, COUNT(transaksipenjualan.kode_transaksi) as transaction_count')
            ->groupBy('pegawai.id_pegawai', 'pegawai.nama') // Ubah 'pegawai.id' menjadi 'pegawai.id_pegawai'
            ->orderBy('transaction_count', 'desc')
            ->get();
    
        // Transformasi data pegawai untuk Chart.js
        $pegawaiNames = $pegawaiTransactions->pluck('pegawai_name'); // Nama pegawai
        $transactionCounts = $pegawaiTransactions->pluck('transaction_count'); // Jumlah transaksi per pegawai

        // Data jenis produk yang terjual
        $productData = DetailTransaksi::join('produk', 'detailtransaksi.id_produk', '=', 'produk.id_produk')
            ->selectRaw('produk.nama_produk as product_name, SUM(detailtransaksi.jumlah) as total_sold')
            ->groupBy('produk.nama_produk')
            ->orderBy('total_sold', 'desc')
            ->get();

        // Transformasi data jenis produk untuk Chart.js
        $productTypes = $productData->pluck('product_name'); // Nama produk
        $productSales = $productData->pluck('total_sold'); // Jumlah produk terjual

        // Data pemasukan bulanan
        $monthlyIncome = $monthlyTransactions->pluck('total'); // Total pemasukan per bulan

        return view('dashboard.index', [
            'totalIncome' => TransaksiPenjualan::sum('total'), // Total pendapatan
            'totalSales' => DetailTransaksi::sum('jumlah'), // Total produk terjual
            'totalProduct' => TransaksiPenjualan::count(), // Total transaksi
            'totalMember' => Member::count(), // Total member
            'monthlyData' => $monthlyData, // Data transaksi bulanan
            'pegawaiNames' => $pegawaiNames, // Nama pegawai
            'transactionCounts' => $transactionCounts, // Jumlah transaksi per pegawai
            'productTypes' => $productTypes, // Jenis produk
            'productSales' => $productSales, // Jumlah produk terjual
            'monthlyIncome' => $monthlyIncome // Total pemasukan bulanan
        ]);
    }    
}
