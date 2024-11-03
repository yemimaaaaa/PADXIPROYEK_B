<?php

namespace App\Http\Controllers;

use App\Models\Stok; // Mengimpor model Stok
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        // Mengambil semua data stok dari database
        $stoks = Stok::all(); 

        // Mengembalikan tampilan dengan data stok
        return view('stok.index', compact('stoks'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $stoks = Stok::where('nama_produk', 'LIKE', "{$query}%")
            ->get();
        
        return view('stok.index', compact('stoks'));
    }
}
