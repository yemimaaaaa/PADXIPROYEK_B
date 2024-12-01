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
use Carbon\Carbon;


class LaporanTransaksiController extends Controller
{
    // Fungsi Index: Menampilkan Data Laporan
    
    public function index(Request $request)
    {
        // Filter berdasarkan query, tanggal mulai, dan akhir
        $query = $request->input('query');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Jika tidak ada tanggal yang dipilih, defaultkan ke tanggal 1 dan tanggal akhir bulan ini
        $startDate = $startDate ?: Carbon::now()->startOfMonth()->toDateString();
        $endDate = $endDate ?: Carbon::now()->endOfMonth()->toDateString();
    
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
    
    
    public function exportExcel(Request $request)
    {
        // Ambil data yang difilter
        $laporantransaksis = $this->getFilteredData($request);
    
        // Export ke Excel
        return Excel::download(new TransaksiExport($laporantransaksis), 'laporan-transaksi.xlsx');
    }
    

    // Fungsi Helper: Ambil Data dengan Filter
    private function getFilteredData(Request $request)
{
    $query = $request->input('query');  // Kata kunci pencarian
    $startDate = $request->input('start_date') ?: Carbon::now()->startOfMonth()->toDateString();  // Tanggal mulai
    $endDate = $request->input('end_date') ?: Carbon::now()->endOfMonth()->toDateString();  // Tanggal selesai

    // Ambil data TransaksiPenjualan dengan relasi yang dibutuhkan
    return TransaksiPenjualan::with(['pegawai', 'member', 'detailtransaksi.produk'])
        ->when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('kode_transaksi', 'like', "%$query%")
                         ->orWhereHas('member', function ($subQuery) use ($query) {
                             $subQuery->where('nama', 'like', "%$query%");
                         });
        })
        ->whereBetween('tanggal_penjualan', [$startDate, $endDate])  // Filter berdasarkan tanggal
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
        
            // Filter Member
            if ($request->input('member_id')) {
                $query->where('id_member', $request->input('member_id'));
            }
        
            // Filter Level Member
            if ($request->input('level_member')) {
                $query->whereHas('member.levelmember', function ($q) use ($request) {
                    $q->where('tingkatan_level', $request->input('level_member'));
                });
            }
        
            // Filter Tanggal
            if ($request->input('start_date') && $request->input('end_date')) {
                $query->whereBetween('tanggal_penjualan', [
                    $request->input('start_date'),
                    $request->input('end_date'),
                ]);
            }
        
            // Filter Bulan
            $selectedMonth = $request->input('month') ?? date('m');
            $query->whereMonth('tanggal_penjualan', $selectedMonth);
        
            // Filter Produk
            if ($request->input('id_produk')) {
                $query->whereHas('detailtransaksi', function ($q) use ($request) {
                    $q->where('id_produk', $request->input('id_produk'));
                });
            }
        
            // Data untuk grafik garis (penjualan harian)
            $laporanData = $query->selectRaw('DATE(tanggal_penjualan) as tanggal, SUM(total) as total_penjualan')
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
        
            $labels = $laporanData->pluck('tanggal')->toArray();
            $data = $laporanData->pluck('total_penjualan')->toArray();
        
            // Data untuk pie chart (penjualan produk)
            $pieQuery = DetailTransaksi::join('produk', 'detailtransaksi.id_produk', '=', 'produk.id_produk')
            ->join('transaksipenjualan', 'detailtransaksi.kode_transaksi', '=', 'transaksipenjualan.kode_transaksi')
            ->selectRaw('produk.nama_produk as nama_produk, SUM(detailtransaksi.jumlah) as jumlah_terjual')
            ->when($request->input('member_id'), function ($q) use ($request) {
                $q->where('transaksipenjualan.id_member', $request->input('member_id'));
            })
            ->when($request->input('level_member'), function ($q) use ($request) {
                $q->whereHas('transaksi.member.levelmember', function ($q2) use ($request) {
                    $q2->where('tingkatan_level', $request->input('level_member'));
                });
            })
            ->when($request->input('start_date') && $request->input('end_date'), function ($q) use ($request) {
                $q->whereBetween('transaksipenjualan.tanggal_penjualan', [
                    $request->input('start_date'),
                    $request->input('end_date'),
                ]);
            })
            ->whereMonth('transaksipenjualan.tanggal_penjualan', $selectedMonth);
        
            // Tambahkan filter produk jika ada
            if ($request->input('id_produk')) {
                $pieQuery->where('produk.id_produk', $request->input('id_produk'));
            }
        
            // Tambahkan filter tanggal jika ada
            if ($request->input('start_date') && $request->input('end_date')) {
                $pieQuery->whereBetween('transaksipenjualan.tanggal_penjualan', [
                    $request->input('start_date'),
                    $request->input('end_date'),
                ]);
            }
        
            $pieQuery->whereMonth('transaksipenjualan.tanggal_penjualan', $selectedMonth);

            $pieData = $pieQuery->groupBy('produk.nama_produk')
                ->orderBy('jumlah_terjual', 'desc')
                ->get();
        
            $pieLabels = $pieData->pluck('nama_produk')->toArray();
            $pieValues = $pieData->pluck('jumlah_terjual')->toArray();
        
            // Log untuk debugging
            Log::info('Pie Chart Query:', [
                'query' => $pieQuery->toSql(),
                'bindings' => $pieQuery->getBindings(),
                'pie_data' => $pieData->toArray(),
            ]);
        
            // Data tambahan untuk filter dropdown
            $members = \App\Models\Member::all();
            $products = \App\Models\Produk::all();
        
            return view('laporantransaksi.grafik', compact('labels', 'data', 'pieLabels', 'pieValues', 'members', 'products', 'selectedMonth'));
        }        
        
}
