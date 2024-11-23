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
use App\Models\Poin;
use App\Enums\PaymentMethod;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Validation\Rule;
use App\Http\Controllers\PoinMemberController;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        // Gunakan paginate dan eager load untuk mengoptimalkan query
        $transaksipenjualans = TransaksiPenjualan::with(['pegawai', 'member'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Menggunakan paginasi
    
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
        Log::info('Nilai yang diterima sebelum validasi:', $request->all());
    
        $validatedData = $request->validate([
            'tanggal_penjualan' => 'required|date',
            'nominal_uang_diterima' => 'required|numeric|min:0',
            'nominal_uang_kembalian' => 'required|numeric|min:0',
            'subtotal_keseluruhan' => 'required|numeric|min:1',
            'subtotal_setelah_diskon' => 'required|numeric|min:1',
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
    
        // Hitung ulang subtotal dan diskon
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
    
        try {
            DB::beginTransaction();
    
            // Generate kode transaksi unik
            $latestTransaksi = TransaksiPenjualan::latest('kode_transaksi')->first();
            $lastNumber = $latestTransaksi ? intval($latestTransaksi->kode_transaksi) : 6013;
            $nextNumber = $lastNumber + 1;
            $kodeTransaksi = $nextNumber;
    
            Log::info('Kode transaksi yang dihasilkan:', ['kode_transaksi' => $kodeTransaksi]);
    
            // Simpan transaksi
            $transaksipenjualan = TransaksiPenjualan::create([
                'kode_transaksi' => $kodeTransaksi,
                'tanggal_penjualan' => $validatedData['tanggal_penjualan'],
                'nominal_uang_diterima' => $validatedData['nominal_uang_diterima'],
                'nominal_uang_kembalian' => $validatedData['nominal_uang_kembalian'],
                'total' => $subtotalSetelahDiskon,
                'payment_method' => $validatedData['payment_method'],
                'id_pegawai' => $validatedData['id_pegawai'],
                'id_member' => $validatedData['id_member'] ?? null,
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
    
            // Hitung poin yang diterima
            $poinDiterima = floor($subtotalSetelahDiskon / 1000); // Hitung poin berdasarkan subtotal setelah diskon
            
            if ($validatedData['id_member']) {
                $member = Member::with('poin')->findOrFail($validatedData['id_member']);
                
                // Simpan poin ke tabel Poin
                Poin::create([
                    'id_member' => $member->id_member,
                    'total_poin' => $poinDiterima, // Menggunakan variabel poinDiterima yang telah dihitung
                    'kode_transaksi' => $transaksipenjualan->kode_transaksi,
                    'tanggal' => now(),
                ]);
            
                Log::info('Poin berhasil ditambahkan:', [
                    'id_member' => $member->id_member,
                    'poin_diterima' => $poinDiterima, // Log juga menggunakan poinDiterima
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

    // Gunakan tingkatan_level untuk menentukan diskon
    $tingkatanLevel = $transaksi->member->levelmember->tingkatan_level ?? null;
    $diskonRate = match (strtolower($tingkatanLevel)) {
        'bronze' => 0.05,
        'silver' => 0.10,
        'gold' => 0.15,
        default => 0, // Tidak ada diskon jika tingkatan_level tidak ditemukan
    };

    // Log untuk debugging
    Log::info('Perhitungan diskon berdasarkan tingkatan_level:', [
        'tingkatan_level' => $tingkatanLevel,
        'diskonRate' => $diskonRate,
    ]);

    // Hitung total diskon
    $totalDiskon = $subtotal * $diskonRate;

    // Hitung total setelah diskon
    $totalSetelahDiskon = $subtotal - $totalDiskon;

    // Hitung poin yang diterima
    $poinDiterima = floor($subtotal / 1000);

    // Log untuk debugging
    Log::info('Perhitungan Transaksi:', [
        'subtotal' => $subtotal,
        'diskonRate' => $diskonRate,
        'totalDiskon' => $totalDiskon,
        'subtotalSetelahDiskon' => $totalSetelahDiskon,
        'poinDiterima' => $poinDiterima,
    ]);

    // Kirim data ke view untuk dicetak sebagai PDF
    return Pdf::loadView('transaksipenjualan.cetak', [
        'transaksi' => $transaksi,
        'subtotal' => $subtotal,
        'totalDiskon' => $totalDiskon,
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

    // Hitung subtotal dari detail transaksi
    $subtotal = $detailtransaksi->sum(function ($item) {
        return $item->harga * $item->jumlah;
    });

    // Gunakan tingkatan_level untuk menentukan diskon
    $tingkatanLevel = $transaksi->member->levelmember->tingkatan_level ?? null;
    $diskonRate = match (strtolower($tingkatanLevel)) {
        'bronze' => 0.05,
        'silver' => 0.10,
        'gold' => 0.15,
        default => 0, // Tidak ada diskon jika tingkatan_level tidak ditemukan
    };

    // Log untuk debugging
    Log::info('Perhitungan diskon berdasarkan tingkatan_level:', [
        'tingkatan_level' => $tingkatanLevel,
        'diskonRate' => $diskonRate,
    ]);

    // Hitung total diskon
    $totalDiskon = $subtotal * $diskonRate;

    // Hitung subtotal setelah diskon
    $subtotalSetelahDiskon = $subtotal - $totalDiskon;

    // Hitung poin yang diterima
    $poinDiterima = floor($subtotal / 1000);

    // Debugging log untuk memastikan perhitungan
    Log::info('Perhitungan Transaksi:', [
        'subtotal' => $subtotal,
        'diskonRate' => $diskonRate,
        'totalDiskon' => $totalDiskon,
        'subtotalSetelahDiskon' => $subtotalSetelahDiskon,
        'poinDiterima' => $poinDiterima,
    ]);

    // Kirim data ke view
    return view('transaksipenjualan.detail', compact(
        'transaksi',
        'detailtransaksi',
        'subtotal',
        'totalDiskon',
        'subtotalSetelahDiskon',
        'poinDiterima'
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