<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailTransaksi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
use Illuminate\Support\Facades\Log;


class LaporanTransaksiController extends Controller
{
    // Fungsi Index: Menampilkan Data Laporan
    
    public function index(Request $request)
{
    // Filter berdasarkan query, tanggal mulai, dan akhir
    $query = $request->input('query');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Ambil data dengan pagination
    $laporantransaksis = TransaksiPenjualan::with(['member', 'pegawai', 'detailtransaksi.produk'])
        ->when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('kode_transaksi', 'like', "%$query%")
                         ->orWhereHas('member', function ($subQuery) use ($query) {
                             $subQuery->where('nama', 'like', "%$query%");
                         });
        })
        ->when($startDate && $endDate, function ($queryBuilder) use ($startDate, $endDate) {
            $queryBuilder->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        })
        ->orderBy('tanggal_penjualan', 'desc')
        ->paginate(10);

        
    // Hitung total penjualan untuk semua data (bukan hanya data yang dipaginate)
    $totalPenjualan = TransaksiPenjualan::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('kode_transaksi', 'like', "%$query%")
                         ->orWhereHas('member', function ($subQuery) use ($query) {
                             $subQuery->where('nama', 'like', "%$query%");
                         });
        })
        ->when($startDate && $endDate, function ($queryBuilder) use ($startDate, $endDate) {
            $queryBuilder->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        })
        ->sum('total');

            return view('laporantransaksi.index', compact('laporantransaksis', 'query', 'startDate', 'endDate', 'totalPenjualan'));
        }
    
    // Fungsi Export PDF
    public function exportPdf(Request $request)
{
    // Ambil data filter lengkap dengan relasi detail transaksi
    $laporantransaksis = $this->getFilteredData($request);

    // Generate PDF, pastikan menggunakan tampilan yang memuat detail transaksi
    $pdf = Pdf::loadView('laporantransaksi.pdf', compact('laporantransaksis'));

    return $pdf->download('laporan-transaksi.pdf');
}

public function exportExcel(Request $request)
{
    // Ambil data filter lengkap dengan relasi detail transaksi
    $laporantransaksis = $this->getFilteredData($request);

    // Generate Excel, pastikan Export class menangani data detail transaksi
    return Excel::download(new TransaksiExport($laporantransaksis), 'laporan-transaksi.xlsx');
}


    // Fungsi Helper: Ambil Data dengan Filter
    private function getFilteredData(Request $request)
    {
        $query = $request->input('query');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        return TransaksiPenjualan::with([
            'pegawai', 
            'member', 
            'detailtransaksi.produk' // Tambahkan relasi detail transaksi dan produk
        ])
        ->when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('kode_transaksi', 'like', "%$query%")
                         ->orWhereHas('member', function ($subQuery) use ($query) {
                             $subQuery->where('nama', 'like', "%$query%");
                         });
        })
        ->when($startDate && $endDate, function ($queryBuilder) use ($startDate, $endDate) {
            $queryBuilder->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        })
        ->orderBy('tanggal_penjualan', 'desc')
        ->get();
    }
    

        public function detail($kode_transaksi)
        {
            // Ambil data transaksi dengan relasi member dan levelmember
            $transaksi = TransaksiPenjualan::with(['pegawai', 'member.levelmember'])
                ->where('kode_transaksi', $kode_transaksi)
                ->firstOrFail();

            // Ambil detail transaksi dan data produk terkait
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

            // Hitung total diskon
            $totalDiskon = $subtotal * $diskonRate;

            // Hitung subtotal setelah diskon
            $subtotalSetelahDiskon = $subtotal - $totalDiskon;

            // Hitung poin yang diterima
            $poinDiterima = floor($subtotal / 1000);

            // Debugging log (opsional)
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

        public function cetak($kode_transaksi)
        {
            $transaksi = TransaksiPenjualan::with(['detailtransaksi.produk', 'member', 'pegawai'])
                ->where('kode_transaksi', $kode_transaksi)
                ->firstOrFail();

            $pdf = Pdf::loadView('laporantransaksi.nota', compact('transaksi'));
            
            // Gunakan download() untuk langsung mengunduh PDF
            return $pdf->download("Nota_Transaksi_{$kode_transaksi}.pdf");
        }

        public function grafik(Request $request)
{
    $query = TransaksiPenjualan::query();

    // Filter untuk grafik garis (penjualan harian)
    if ($request->id_member) {
        $query->where('id_member', $request->id_member);
    }

    if ($request->levelmember) {
        $query->whereHas('member', function ($q) use ($request) {
            $q->where('levelmember', $request->levelmember);
        });
    }

    if ($request->start_date && $request->end_date) {
        $query->whereBetween('tanggal_penjualan', [$request->start_date, $request->end_date]);
    }

    if ($request->id_produk) {
        $query->whereHas('produk', function ($q) use ($request) {
            $q->where('id_produk', $request->id_produk);
        });
    }

    // Filter bulan untuk grafik garis
    $selectedMonth = $request->input('month') ?? date('m'); // Default ke bulan saat ini jika tidak dipilih
    $query->whereMonth('tanggal_penjualan', $selectedMonth);

    // Data untuk grafik garis (penjualan harian)
    $laporanData = $query->selectRaw('DATE(tanggal_penjualan) as tanggal, SUM(total) as total_penjualan')
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    $labels = $laporanData->pluck('tanggal')->toArray(); // Tanggal untuk label grafik
    $data = $laporanData->pluck('total_penjualan')->toArray(); // Total penjualan untuk grafik

    // Filter bulan untuk chart pie
    $pieData = DetailTransaksi::join('produk', 'detailtransaksi.id_produk', '=', 'produk.id_produk')
        ->join('transaksipenjualan', 'detailtransaksi.kode_transaksi', '=', 'transaksipenjualan.kode_transaksi')
        ->selectRaw('produk.nama_produk as nama_produk, SUM(detailtransaksi.jumlah) as jumlah_terjual')
        ->whereMonth('transaksipenjualan.tanggal_penjualan', $selectedMonth)
        ->groupBy('produk.nama_produk')
        ->orderBy('jumlah_terjual', 'desc')
        ->get();

    $pieLabels = $pieData->pluck('nama_produk')->toArray();
    $pieValues = $pieData->pluck('jumlah_terjual')->toArray();

    $members = \App\Models\Member::all(); // Untuk filter member
    $products = \App\Models\Produk::all(); // Untuk filter produk

    return view('laporantransaksi.grafik', compact('labels', 'data', 'pieLabels', 'pieValues', 'members', 'products', 'selectedMonth'));
}
}
