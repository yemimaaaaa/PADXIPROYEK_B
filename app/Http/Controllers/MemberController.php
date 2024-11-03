<?php

namespace App\Http\Controllers;

use App\Models\Member; // Mengimpor model Produk
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        // Mengambil semua data produk dari database
        $members = Member::all(); 

        // Mengembalikan tampilan dengan data produk
        return view('member.index', compact('members'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $members = Member::where('nama', 'LIKE', "{$query}%")
            ->orWhere('no_hp', 'LIKE', "%{$query}%")
            ->get();
        
        return view('member.index', compact('members'));
    }
}
