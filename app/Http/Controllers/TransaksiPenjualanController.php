<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan; // Ensure this is the correct model path
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
        
        // Search in the transaksi_penjualans table based on kode_transaksi
        $transaksipenjualans = TransaksiPenjualan::where('kode_transaksi', 'LIKE', "%{$query}%")
            ->with('pegawai') // Eager load pegawai relationship
            ->get();
        
        return view('transaksipenjualan.index', compact('transaksipenjualans'));
    }
}
