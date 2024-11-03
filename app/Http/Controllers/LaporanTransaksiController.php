<?php

namespace App\Http\Controllers;

use App\Models\Produk; // Mengimpor model Produk
use Illuminate\Http\Request;

class LaporanTransaksiController extends Controller
{
    public function index()
    {
        // Mengambil semua data produk dari database
        $laporantransaksis = Produk::all(); 

        // Mengembalikan tampilan dengan data produk
        return view('laporantransaksi.index', compact('laporantransaksis'));
    }
}
