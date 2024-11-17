<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\TransaksiPenjualan; // Pastikan model yang digunakan sesuai
use App\Models\Pegawai;
use App\Models\Member;
use App\Models\Produk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpParser\Node\Stmt\Foreach_;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        // Eager load the pegawai relationship to avoid N+1 query problem
        $transaksipenjualans = TransaksiPenjualan::with(['pegawai', 'member'])->get();
        return view('transaksipenjualan.index', compact('transaksipenjualans'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Search in the transaksi_penjualans table based on kode_transaksi
        $transaksipenjualans = TransaksiPenjualan::where('kode_transaksi', 'LIKE', "%{$query}%")
            ->with('pegawai') // Eager load pegawai relationship
            ->get();
        
        return view('transaksipenjualan.index', compact('transaksipenjualans'));
    }

    public function create()
    {
        // Ambil data pegawai dan member untuk dropdown
        $pegawais = Pegawai::all(); // Mengambil semua pegawai
        // $members = Member::select('nama', 'id_member', 'id_level_member')->get();
        $members = Member::select(
            'member.nama',
            'member.id_member',
            'member.id_level_member',
            'levelmember.tingkatan_level'
        )
        ->leftJoin('levelmember', 'member.id_level_member', '=', 'levelmember.id_level_member')
        ->get();
        //return view('transaksipenjualan.create', compact('members', 'produks'));        
        $produks = Produk::all(); // Mengambil semua produk

        dd($members->toArray()); // Debug untuk memastikan data members
        // Kirim data pegawai dan member ke view
        return view('transaksipenjualan.create', compact('pegawais', 'members', 'produks'));
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
{
    //dd($request->all());
    // Validasi input
    $validatedData = $request->validate([
        'tanggal_transaksi' => 'required|date',
        'nominal_uang_diterima' => 'required|numeric|min:0',
        'nominal_uang_kembalian' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
        'payment_method' => 'required|string|max:255',
        'id_pegawai' => 'required|exists:pegawai,id_pegawai',
        'id_member' => 'nullable|exists:member,id_member',
    ]);

    $member = Member::find($validatedData['id_member']);
    $diskonRate = 0;

    if ($member) {
        switch ($member->id_level_member) {
            case 1:
                $diskonRate = 0.05;
                break;
            case 2:
                $diskonRate = 0.15;
                break;
            case 3:
                $diskonRate = 0.25;
                break;
        }
    }

    $totalDiskon = $validatedData['total'] * $diskonRate;

    // Generate kode transaksi unik
    $currentDate = now()->format('Ymd'); // Format: YYYYMMDD
    $latestTransaksi = TransaksiPenjualan::whereDate('created_at', now())->latest('id')->first();
    $nextNumber = $latestTransaksi ? intval(substr($latestTransaksi->kode_transaksi, -4)) + 1 : 1;
    $kodeTransaksi = 'TRX-' . $currentDate . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    // Tambahkan kode transaksi ke dalam data validasi
    $validatedData['kode_transaksi'] = $kodeTransaksi;    

    // Simpan data transaksi ke tabel TransaksiPenjualan
    $transaksipenjualan = TransaksiPenjualan::create([
        'kode_transaksi' => $kodeTransaksi,
        'tanggal_transaksi' => $validatedData['tanggal_transaksi'],
        'nominal_uang_diterima' => $validatedData['nominal_uang_diterima'],
        'nominal_uang_kembalian' => $validatedData['nominal_uang_kembalian'],
        'total' => $validatedData['total'],
        'payment_method' => $validatedData['payment_method'],
        'id_pegawai' => $validatedData['id_pegawai'],
        'id_member' => $validatedData['id_member'] ?? null,
    ]);

    // Simpan detail transaksi
    foreach ($request->produk as $produk) {
        $latestDetail = DetailTransaksi::latest('id_detail_transaksi')->first();
        $newIdDetail = $latestDetail ? intval($latestDetail->id_detail_transaksi) + 1 : 1;

        $produkModel = Produk::findOrFail($produk['id_produk']);
        $harga = $produkModel->harga;
        $subtotal = $harga * $produk['jumlah'];

        DetailTransaksi::create([
            'id_detail_transaksi' => $newIdDetail,
            'kode_transaksi' => $transaksipenjualan->kode_transaksi, // Menggunakan objek $transaksipenjualan
            'id_produk' => $produk['id_produk'],
            'tanggal_penjualan' => $validatedData['tanggal_transaksi'],
            'jumlah' => $produk['jumlah'],
            'subtotal' => $subtotal,
        ]);
    }

    // Redirect dengan pesan sukses
    return redirect()->route('transaksipenjualan.index')->with('success', 'Transaksi berhasil ditambahkan!');
}
    public function edit($kode_transaksi)
    {
        $transaksi = TransaksiPenjualan::where('kode_transaksi', $kode_transaksi)->firstOrFail();
        //$pegawais = Pegawai::all(); // Mengambil semua pegawai untuk dropdown
        return view('transaksipenjualan.edit', compact('transaksi'));
    }

    public function update(Request $request, $kode_transaksi)
{
    // Validasi input
    $validatedData = $request->validate([
        'id_pegawai' => 'required|exists:pegawais,id_pegawai',
        'tanggal_transaksi' => 'required|date',
        'total_harga' => 'required|numeric|min:0',
        'nominal_uang_diterima' => 'required|numeric|min:0',
        'nominal_uang_kembalian' => 'required|numeric|min:0',
        'payment_method' => 'required|string|max:255',
        'id_member' => 'nullable|exists:members,id_member', // id_member opsional dan harus valid jika diisi
    ]);

    // Temukan transaksi berdasarkan kode_transaksi
    $transaksi = TransaksiPenjualan::where('kode_transaksi', $kode_transaksi)->firstOrFail();

    // Perbarui data transaksi tanpa mengubah kode_transaksi
    $transaksi->update([
        'id_pegawai' => $validatedData['id_pegawai'],
        'tanggal_transaksi' => $validatedData['tanggal_transaksi'],
        'total_harga' => $validatedData['total_harga'],
        'nominal_uang_diterima' => $validatedData['nominal_uang_diterima'],
        'nominal_uang_kembalian' => $validatedData['nominal_uang_kembalian'],
        'payment_method' => $validatedData['payment_method'],
        'id_member' => $validatedData['id_member'] ?? null, // Simpan null jika id_member tidak diisi
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('transaksipenjualan.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function cetak($kode_transaksi)
    {
        // Ambil data transaksi dengan relasi pegawai
        $transaksi = TransaksiPenjualan::where('kode_transaksi', $kode_transaksi)
            ->with('pegawai')
            ->firstOrFail();

        // Load view cetak dan passing data transaksi
        $pdf = Pdf::loadView('transaksipenjualan.cetak', compact('transaksi'))
            ->setPaper('a4', 'portrait'); // Atur ukuran kertas dan orientasi

        // Unduh sebagai PDF
        return $pdf->download("Nota_Transaksi_{$kode_transaksi}.pdf");
    }

}

