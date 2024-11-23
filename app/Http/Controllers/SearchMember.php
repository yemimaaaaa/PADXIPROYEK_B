<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        $members = Member::where('name', 'like', '%' . $query . '%')
            ->orWhere('phone', 'like', '%' . $query . '%')
            ->get();

        return view('member.search', compact('members', 'query'));
    }
}
