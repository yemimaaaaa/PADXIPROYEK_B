<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class PoinMemberController extends Controller
{
    public function index()
    {
        $members = Member::withSum('poins', 'total_poin') // Hitung total poin untuk setiap member
            ->orderBy('nama', 'asc')
            ->get();
    
        return view('poinmember.index', compact('members'));
    }
    
    // Update poin member secara manual
    public function update(Request $request, $id_member)
    {
        // Validasi input
        $request->validate([
            'poin' => 'required|integer|min:0',
        ]);

        // Cari member berdasarkan ID
        $member = Member::findOrFail($id_member);

        // Update poin member
        $member->poin = $request->poin;
        $member->save();

        return redirect()->route('poinmember.index')->with('success', 'Poin member berhasil diperbarui.');
    }

    // Fungsi untuk menambahkan poin otomatis setelah transaksi
//     public function tambahPoinMember($id_member, $poinDiterima)
// {
//     $member = Member::find($id_member);

//     if ($member) {
//         // Ambil atau buat entri poin
//         $poin = Poin::firstOrNew(['id_member' => $id_member]);

//         // Pastikan total_poin terinisialisasi
//         $poin->total_poin = ($poin->total_poin ?? 0) + $poinDiterima;
//         $poin->tanggal = now();
//         $poin->save();

//         // Update poin langsung di tabel Member
//         $member->poin += $poinDiterima;
//         $member->save();

//         Log::info('Poin berhasil ditambahkan:', [
//             'id_member' => $id_member,
//             'poinDiterima' => $poinDiterima,
//             'totalPoin' => $poin->total_poin,
//         ]);
//     } else {
//         Log::warning('Member tidak ditemukan:', ['id_member' => $id_member]);
//     }
// }

    
}
