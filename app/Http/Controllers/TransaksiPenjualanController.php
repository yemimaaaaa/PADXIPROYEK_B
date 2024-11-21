<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\TransaksiPenjualan; // Pastikan model yang digunakan sesuai
use App\Models\Pegawai;
use App\Models\Member;
use App\Models\Produk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\PaymentMethod;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Validation\Rule;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        // Eager load the pegawai relationship to avoid N+1 query problem
        $transaksipenjualans = TransaksiPenjualan::with(['pegawai', 'member'])
        ->orderBy('created_at', 'desc')
        ->get();

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

        //dd($members->toArray()); // Debug untuk memastikan data members
        // Kirim data pegawai dan member ke view
        return view('transaksipenjualan.create', compact('pegawais', 'members', 'produks'));
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
{
    //dd($request->all());
    Log::info('Nilai yang diterima sebelum validasi:', $request->all());

    $validatedData = $request->validate([
        'tanggal_penjualan' => 'required|date',
        'nominal_uang_diterima' => 'required|numeric|min:0',
        'nominal_uang_kembalian' => 'required|numeric|min:0',
        'subtotal_keseluruhan' => 'required|numeric|min:1',
        'subtotal_setelah_diskon' => 'required|numeric|min:1',
        // 'payment_method' => 'required|in:cash,debit,e_wallet',
        //'payment_method' => ['required', Rule::in(array_column(\App\Enums\PaymentMethod::cases(), 'value'))],
        'payment_method' => [
            'required',
            Rule::in(array_map('strtolower', array_column(\App\Enums\PaymentMethod::cases(), 'value')))
        ],
        'id_pegawai' => 'required|exists:pegawai,id_pegawai',
        'id_member' => 'nullable|exists:member,id_member',
        'produk' => 'required|array|min:1',
        'produk.*.id_produk' => 'required|exists:produk,id_produk',
        'produk.*.jumlah' => 'required|integer|min:1',
    ]);
    $validatedData['payment_method'] = (string) strtolower($validatedData['payment_method']);
    $validatedData['nominal_uang_diterima'] = (float) $validatedData['nominal_uang_diterima'];
    $validatedData['nominal_uang_kembalian'] = (float) $validatedData['nominal_uang_kembalian'];

    // Hitung ulang jika subtotal_keseluruhan kosong
    $totalHarga = collect($request->produk)->reduce(function ($carry, $item) {
        $produk = Produk::findOrFail($item['id_produk']);
        return $carry + ($produk->harga * $item['jumlah']);
    }, 0);

    $diskonRate = 0;
    $member = Member::find($request->id_member);
    if ($member) {
        switch ($member->id_level_member) {
            case 1: $diskonRate = 0.05; break;
            case 2: $diskonRate = 0.10; break;
            case 3: $diskonRate = 0.15; break;
        }
    }

    $totalDiskon = $totalHarga * $diskonRate;
    $subtotalSetelahDiskon = $totalHarga - $totalDiskon;

    // // Gunakan hasil hitungan jika data dari form kosong
    // $validatedData['subtotal_keseluruhan'] = $validatedData['subtotal_keseluruhan'] ?: $totalHarga;
    // $validatedData['subtotal_setelah_diskon'] = $validatedData['subtotal_setelah_diskon'] ?: $subtotalSetelahDiskon;

    // Validasi nilai yang dihitung ulang
    $validatedData['subtotal_keseluruhan'] = $totalHarga; // Tetap dihitung, tetapi tidak disimpan
    $validatedData['subtotal_setelah_diskon'] = $subtotalSetelahDiskon;

    Log::info('Nilai setelah dihitung ulangg:', [
        'subtotal_keseluruhan' => $totalHarga,
        'subtotal_setelah_diskon' => $subtotalSetelahDiskon,
        'total_diskon' => $totalDiskon,
    ]);

    // Log::info('Nilai setelah dihitung ulang:', [
    //     //'subtotal_keseluruhan' => $validatedData['subtotal_keseluruhan'],
    //     'subtotal_setelah_diskon' => $validatedData['subtotal_setelah_diskon'],
    //     'total_diskon' => $totalDiskon,
    // ]);

    try {
        DB::beginTransaction();

        // // Generate kode transaksi unik
        // $currentDate = now()->format('Ymd'); // Format: YYYYMMDD
        // $latestTransaksi = TransaksiPenjualan::whereDate('created_at', now())->latest('id')->first();
        // $nextNumber = $latestTransaksi ? intval(substr($latestTransaksi->kode_transaksi, -4)) + 1 : 1;
        // $kodeTransaksi = 'TRX-' . $currentDate . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Generate kode transaksi unik (berdasarkan transaksi terakhir)
        $latestTransaksi = TransaksiPenjualan::latest('kode_transaksi')->first(); // Ambil transaksi terakhir berdasarkan kode_transaksi

        // Ambil angka terakhir dari kode transaksi atau mulai dari 6013 jika belum ada transaksi
        $lastNumber = $latestTransaksi ? intval($latestTransaksi->kode_transaksi) : 6013;

        // Tambahkan 1 untuk transaksi berikutnya
        $nextNumber = $lastNumber + 1;

        // Gunakan nextNumber sebagai kode transaksi baru
        $kodeTransaksi = $nextNumber;

        Log::info('Kode transaksi yang dihasilkan:', ['kode_transaksi' => $kodeTransaksi]);
        
        // Lanjutkan penyimpanan transaksi
        $transaksipenjualan = TransaksiPenjualan::create([
            'kode_transaksi' => $kodeTransaksi, // Buat kode transaksi
            'tanggal_penjualan' => $validatedData['tanggal_penjualan'],
            'nominal_uang_diterima' => $validatedData['nominal_uang_diterima'],
            'nominal_uang_kembalian' => $validatedData['nominal_uang_kembalian'],
            //'subtotal_keseluruhan' => $validatedData['subtotal_keseluruhan'],
            //'subtotal_setelah_diskon' => $validatedData['subtotal_setelah_diskon'],
            //'total' => $validatedData['subtotal_setelah_diskon'],
            'total' => $subtotalSetelahDiskon,
            'payment_method' => $validatedData['payment_method'],
            //'payment_method' => 'debit',
            'id_pegawai' => $validatedData['id_pegawai'],
            //'id_member' => $validatedData['id_member'],
            'id_member' => $validatedData['id_member'] ?? null, // Pastikan null ditangani
        ]);

        // Simpan detail transaksi
        foreach ($validatedData['produk'] as $produk) {
            DetailTransaksi::create([
                'kode_transaksi' => $transaksipenjualan->kode_transaksi,
                'id_produk' => $produk['id_produk'],
                'jumlah' => $produk['jumlah'],
                'subtotal' => Produk::find($produk['id_produk'])->harga * $produk['jumlah'],
                'tanggal_penjualan' => $validatedData['tanggal_penjualan'],
            ]);
        }

        DB::commit();
        Log::info('Transaksi berhasil disimpan.');

        return redirect()->route('transaksipenjualan.index')->with('success', 'Transaksi berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal menyimpan transaksi:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function cetak($kode_transaksi)
{
    // Ambil data transaksi beserta relasi
    $transaksi = TransaksiPenjualan::with(['pegawai', 'member.levelmember', 'detailtransaksi.produk'])
        ->where('kode_transaksi', $kode_transaksi)
        ->firstOrFail();

    // Hitung subtotal dari detail transaksi
    $subtotal = $transaksi->detailtransaksi->sum('subtotal');

    // Ambil diskon berdasarkan level member
    $diskonRate = 0;
    if ($transaksi->member && $transaksi->member->id_level_member) {
        switch ($transaksi->member->id_level_member) {
            case 1: $diskonRate = 0.05; break; // Bronze
            case 2: $diskonRate = 0.10; break; // Silver
            case 3: $diskonRate = 0.15; break; // Gold
        }
    }

    // Hitung total diskon
    $totalDiskon = $subtotal * $diskonRate;

    // Hitung total setelah diskon
    $totalSetelahDiskon = $subtotal - $totalDiskon;

    // Hitung poin yang diterima
    $poinDiterima = floor($totalSetelahDiskon / 1000);

    // Log untuk debugging
    Log::info('Detail transaksi:', [
        'subtotal' => $subtotal,
        'diskonRate' => $diskonRate,
        'totalDiskon' => $totalDiskon,
        'totalSetelahDiskon' => $totalSetelahDiskon,
        'poinDiterima' => $poinDiterima,
    ]);

    // Kirim data ke view
    return Pdf::loadView('transaksipenjualan.cetak', [
        'transaksi' => $transaksi,
        'subtotal' => $subtotal,
        'totalDiskon' => $totalDiskon, // Pastikan variabel ini dikirim
        'totalSetelahDiskon' => $totalSetelahDiskon,
        'poinDiterima' => $poinDiterima,
    ])->download('nota-transaksi-' . $transaksi->kode_transaksi . '.pdf');
}

public function detail($kode_transaksi)
{
    $transaksi = TransaksiPenjualan::with(['pegawai', 'member.levelmember'])
        ->where('kode_transaksi', $kode_transaksi)
        ->firstOrFail();

    $detailtransaksi = DetailTransaksi::where('kode_transaksi', $kode_transaksi)
        ->join('produk', 'detailtransaksi.id_produk', '=', 'produk.id_produk')
        ->select('detailtransaksi.*', 'produk.nama_produk', 'produk.harga')
        ->get();

    // Hitung subtotal
    $subtotal = $detailtransaksi->sum(function ($item) {
        return $item->harga * $item->jumlah;
    });

    // Cek apakah member memiliki level
    $diskonRate = 0;
    if ($transaksi->member && $transaksi->member->id_level_member) {
        switch ($transaksi->member->id_level_member) {
            case 1: $diskonRate = 0.05; break; // Bronze
            case 2: $diskonRate = 0.10; break; // Silver
            case 3: $diskonRate = 0.15; break; // Gold
        }
    }

    // Debug untuk memastikan nilai diskon
    Log::info('Debug Member dan Diskon:', [
        'member_id' => $transaksi->member->id_member ?? 'Tidak Ada Member',
        'id_level_member' => $transaksi->member->id_level_member ?? 'Tidak Ada Level',
        'diskonRate' => $diskonRate,
    ]);

    // Hitung total diskon
    $totalDiskon = $subtotal * $diskonRate;

    // Subtotal setelah diskon
    $subtotalSetelahDiskon = $subtotal - $totalDiskon;

    // Poin diterima
    $poinDiterima = $subtotalSetelahDiskon > 0 ? floor($subtotalSetelahDiskon / 1000) : 0;

    // Log untuk memastikan perhitungan
    Log::info('Detail Transaksi:', [
        'subtotal' => $subtotal,
        'diskonRate' => $diskonRate,
        'totalDiskon' => $totalDiskon,
        'subtotalSetelahDiskon' => $subtotalSetelahDiskon,
        'poinDiterima' => $poinDiterima,
    ]);

    return view('transaksipenjualan.detail', compact(
        'transaksi', 'detailtransaksi', 'subtotal', 'totalDiskon', 'subtotalSetelahDiskon', 'poinDiterima'
    ));
}



public function destroy($kodeTransaksi)
{
    $transaksi = TransaksiPenjualan::where('kode_transaksi', $kodeTransaksi)->firstOrFail();

    // Hapus transaksi
    $transaksi->delete();

    return redirect()->route('transaksipenjualan.index')->with('success', 'Data transaksi berhasil dihapus!');
}

}
