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
        
        // Pastikan kolom nama_stok yang digunakan untuk pencarian
        $stoks = Stok::where('nama_stok', 'LIKE', "%{$query}%")->get();
        
        // Kembalikan hasil ke view stok.index
        return view('stok.index', compact('stoks'));
    }
}
