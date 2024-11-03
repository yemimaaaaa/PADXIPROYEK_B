<?php

namespace App\Http\Controllers;

use App\Models\Pegawai; // Mengimpor model Pegawai
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        // Mengambil semua data pegawai dari database
        $pegawais = Pegawai::all(); 

        // Mengembalikan tampilan dengan data pegawai
        return view('pegawai.index', compact('pegawais'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $pegawais = Pegawai::where('nama', 'LIKE', "{$query}%")
            ->orWhere('no_hp', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();
        
        return view('pegawai.index', compact('pegawais'));
    }
}
