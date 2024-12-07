<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class CekMemberController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian
        $query = $request->input('search');
        $members = null;

        // Query untuk mendapatkan data member dengan poin total dan level member
        $members = Member::with(['levelmember'])
            ->withSum('poin as total_poin', 'total_poin') // Menggunakan withSum untuk menghitung poin
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('nama', 'like', '%' . $query . '%')
                    ->orWhere('no_hp', 'like', '%' . $query . '%');
            })
            ->paginate(10); // Pagination default

        return view('cekmember.index', compact('members', 'query'));
    }
}