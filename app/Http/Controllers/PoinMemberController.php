<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoinMember;

class PoinMemberController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan data poin
        return view('poinmember.index'); // Pastikan view ini ada
    }
}
