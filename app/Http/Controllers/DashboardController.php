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
        $totalIncome = TransaksiPenjualan::sum('subtotal'); // Menghitung total pendapatan
        $totalSales = TransaksiPenjualan::count(); // Menghitung total penjualan
        $totalProduct = Produk::count(); // Menghitung total produk
        $totalMember = Member::count(); // Menghitung total customer

        // Mengembalikan tampilan dashboard dengan variabel yang diperlukan
        return view('dashboard.index', compact('totalIncome', 'totalSales', 'totalProduct', 'totalMember'));
    }
}
