<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class PublicMemberController extends Controller
{
    // Pastikan tidak ada middleware auth di konstruktor
    // public function __construct()
    // {
    //     $this->middleware('auth'); // HAPUS baris ini jika ada
    // }

    public function index()
    {
        $members = Member::with('levelmember')->get();
        return view('member.index', compact('members'));
    }

    public function searchProfile(Request $request)
    {
        $query = $request->input('query');
    
        $member = Member::with('levelmember')
            ->where('nama', 'LIKE', "%{$query}%")
            ->orWhere('no_hp', 'LIKE', "%{$query}%")
            ->first();
    
        if (!$member) {
            // Redirect ke view notfound jika tidak ada member
            return view('member.notfound');
        }
    
        // Redirect ke view profile jika ditemukan
        return view('member.profile', compact('member'));
    }
    
}

