<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiPenjualan extends Model
{
    use HasFactory, SoftDeletes;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel (plural)
    protected $table = 'transaksipenjualan';

    // Tentukan primary key jika berbeda dari id
    protected $primaryKey = 'kode_transaksi';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'tanggal_penjualan',
        'nominal_uang_diterima',
        'nominal_uang_kembalian',
        'subtotal',
        'payment_method',
        'id_pegawai',
        'id_member',
    ];

    // Tentukan jika ada kolom timestamps (created_at, updated_at)
    public $timestamps = true;

    // Tentukan jika ada kolom soft delete (deleted_at)
    protected $dates = ['deleted_at'];

    // Relasi ke tabel Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    // Relasi ke tabel Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }
}
