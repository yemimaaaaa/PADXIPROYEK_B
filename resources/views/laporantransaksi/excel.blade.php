<?php
namespace App\Exports;

use App\Models\TransaksiPenjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiExport implements FromCollection, WithHeadings
{
    protected $laporantransaksis;
    public function __construct($laporantransaksis)
    {
        $this->laporantransaksis = $laporantransaksis;
    }
    public function collection()
    {
        // Ambil data transaksi dan detail transaksi dalam bentuk collection
        return $this->laporantransaksis->map(function ($transaksi) {
            return [
                'Kode Transaksi' => $transaksi->kode_transaksi,
                'Nama Member' => $transaksi->member->nama ?? 'Tidak Diketahui',
                'Tanggal Transaksi' => $transaksi->tanggal_penjualan,
                'Total' => $transaksi->total,
                'Metode Pembayaran' => $transaksi->payment_method ?? 'Tidak Diketahui',
                'Pegawai' => $transaksi->pegawai->nama ?? 'Tidak Diketahui',
                'Detail Transaksi' => $transaksi->detailtransaksi->map(function ($detail) {
                    return [
                        'Nama Produk' => $detail->produk->nama_produk ?? 'Tidak Diketahui',
                        'Harga' => $detail->produk->harga,
                        'Jumlah' => $detail->jumlah,
                        'Subtotal' => $detail->produk->harga * $detail->jumlah,
                    ];
                }),
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Nama Member',
            'Tanggal Transaksi',
            'Total',
            'Metode Pembayaran',
            'Pegawai',
            'Detail Transaksi',
        ];
    }
}