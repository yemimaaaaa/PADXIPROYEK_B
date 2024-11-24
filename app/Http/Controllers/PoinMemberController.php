<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\DB; // Tambahkan namespace ini

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

    public function showDetail($id_member)
    {
        // Ambil data member dan total poin tanpa relasi transaksi
        $member = Member::select('id_member', 'nama')
            ->withSum('poin as poins_sum_total_poin', 'total_poin')
            ->findOrFail($id_member);
    
        // Ambil data transaksi secara manual
        $transaksiPenjualans = DB::table('transaksipenjualan')
            ->leftJoin('detailtransaksi', 'transaksipenjualan.kode_transaksi', '=', 'detailtransaksi.kode_transaksi')
            ->leftJoin('produk', 'detailtransaksi.id_produk', '=', 'produk.id_produk')
            ->leftJoin('pegawai', 'transaksipenjualan.id_pegawai', '=', 'pegawai.id_pegawai')
            ->where('transaksipenjualan.id_member', $id_member)
            ->select(
                'transaksipenjualan.kode_transaksi',
                'transaksipenjualan.tanggal_penjualan',
                'transaksipenjualan.total',
                'pegawai.nama as nama_pegawai',
                'transaksipenjualan.payment_method',
                DB::raw("SUM(detailtransaksi.jumlah * produk.harga) as total_poin"),
                DB::raw("GROUP_CONCAT(produk.nama_produk || ' (' || detailtransaksi.jumlah || 'x' || produk.harga || ')') as detail_produk")
            )
            ->groupBy(
                'transaksipenjualan.kode_transaksi',
                'transaksipenjualan.tanggal_penjualan',
                'transaksipenjualan.total',
                'pegawai.nama',
                'transaksipenjualan.payment_method'
            )
            ->get()
            ->map(function ($transaksi) {
                // Tambahkan perhitungan poin per transaksi
                $transaksi->poin_diterima = round($transaksi->total / 1000); // Misalnya, 1 poin untuk setiap Rp 1000
                return $transaksi;
            });
    
        return view('poinmember.detail', compact('member', 'transaksiPenjualans'));
    }
    
}
