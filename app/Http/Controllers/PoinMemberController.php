<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class PoinMemberController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query pencarian jika ada
        $query = $request->input('query');

        // Filter berdasarkan pencarian atau ambil semua data
        $members = Member::withSum('poin as poins_sum_total_poin', 'total_poin')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('id_member', 'like', "%$query%")
                    ->orWhere('nama', 'like', "%$query%");
            })
            ->orderBy('id_member', 'asc') // Urutkan berdasarkan ID Member
            ->get();

        return view('poinmember.index', compact('members', 'query'));
    }
}
