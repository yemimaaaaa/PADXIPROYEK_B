<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan; // Mengimpor model Stok
use Illuminate\Http\Request;

class TransaksiPenjualanController extends Controller
{
    public function index()
{
        // Eager load the pegawai relationship to avoid N+1 query problem
        $transaksipenjualans = TransaksiPenjualan::with('pegawai')->get(); 

        // Return the view with the data
        return view('transaksipenjualan.index', compact('transaksipenjualans'));
}
public function search(Request $request)
{
    $query = $request->input('query');
    
    $transaksipenjualans = Transaksipenjualan::where('kode_transaksi', 'LIKE', "{$query}%")
        ->get();
    
    return view('transaksipenjualan.index', compact('transaksipenjualans'));
}
}
    