<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PaymentMethod;

class TransaksiPenjualan extends Model
{
    use HasFactory, SoftDeletes;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel (plural)
    protected $table = 'transaksipenjualan';

    // Tentukan primary key jika berbeda dari id
    protected $primaryKey = 'kode_transaksi';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
            //'kode_transaksi',
            'tanggal_penjualan',
            'nominal_uang_diterima',
            'nominal_uang_kembalian',
            'subtotal_keseluruhan', // Pastikan ini ada jika Anda ingin menyimpan subtotal keseluruhan
            'subtotal_setelah_diskon',
            'payment_method', 
            'id_pegawai',
            'id_member',
            'total',
            'total_diskon',
        ];

    // Tentukan jika ada kolom timestamps (created_at, updated_at)
    public $timestamps = true;

    // Tentukan jika ada kolom soft delete (deleted_at)
    protected $dates = ['deleted_at'];

    // Casting kolom payment_method ke enum
    protected $casts = [
        'payment_method' => PaymentMethod::class,
    ];

    // Relasi ke tabel Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    // Relasi ke tabel Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member')->withDefault(
            [
                'nama' => '(Tanpa Member)',
                'tingkatan_level' => 'N/A'
            ]
        );
    }

    public function detailtransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'kode_transaksi', 'kode_transaksi');
    }
    

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function levelmember()
    {
        return $this->belongsTo(LevelMember::class, 'id_level_member', 'id_level_member');
    }
    
}
