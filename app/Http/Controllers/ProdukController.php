<?php

namespace App\Http\Controllers;

use App\Models\Produk; // Mengimpor model Produk
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        // Mengambil semua data produk dari database
        $produks = Produk::all(); 

        // Mengembalikan tampilan dengan data produk
        return view('produk.index', compact('produks'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $produks = Produk::where('nama_produk', 'LIKE', "{$query}%")
            ->get();
        
        return view('produk.index', compact('produks'));
    }
}
