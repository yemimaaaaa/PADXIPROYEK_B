<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\Produk;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncome = TransaksiPenjualan::sum('total'); // Menghitung total pendapatan
        $totalSales = TransaksiPenjualan::count(); // Menghitung total penjualan
        $totalProduct = Produk::count(); // Menghitung total produk
        $totalMember = Member::count(); // Menghitung total customer

        // Mengembalikan tampilan dashboard dengan variabel yang diperlukan
        return view('dashboard.index', compact('totalIncome', 'totalSales', 'totalProduct', 'totalMember'));
    }
    // public function showSalesChart()
    // {
    //     $transactions = TransaksiPenjualan::selectRaw('MONTH(tanggal_transaksi) as month, COUNT(*) as total')
    //         ->groupBy('month')
    //         ->pluck('total', 'month');

    //     // Format data untuk setiap bulan
    //     $monthlySales = array_fill(1, 12, 0); // Isi awal 0 untuk 12 bulan
    //     foreach ($transactions as $month => $total) {
    //         $monthlySales[$month] = $total;
    //     }

    //     return view('sales-chart', ['monthlySales' => array_values($monthlySales)]);
    // }

}
