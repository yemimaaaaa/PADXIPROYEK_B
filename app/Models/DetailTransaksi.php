<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detailtransaksi'; // Sesuaikan dengan nama tabel
    protected $primaryKey = 'id_detail_transaksi'; // Sesuaikan jika primary key bukan "id"

    protected $fillable = [
        'kode_transaksi',
        'id_produk',
        'jumlah',
        'subtotal',
        'tanggal_penjualan',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'kode_transaksi', 'kode_transaksi');
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

}
