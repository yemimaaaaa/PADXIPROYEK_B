<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksi extends Model
{
    use SoftDeletes;

    protected $table = 'detailtransaksi'; // Nama tabel custom
    protected $primaryKey = 'id_detail_transaksi'; // Primary key custom

    protected $fillable = [
        'tanggal_penjualan',
        'jumlah',              
        'subtotal',    
        'kode_transaksi',
        'id_produk'
    ];

    // Tidak perlu mendeklarasikan deleted_at sejak Laravel 8+
    protected $dates = ['deleted_at'];

    public $timestamps = true; // Mengaktifkan timestamps

    // public function transaksipenjualan()
    // {
    //     return $this->belongsTo(TransaksiPenjualan::class, 'kode_pegawai');
    // }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
