<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poin extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'poin';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_poin';
    public $incrementing = true;

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'tanggal',
        'total_poin',              
        'kode_transaksi',       
        'id_member',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }    

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'kode_transaksi', 'kode_transaksi');
    }
    
}