<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel (plural)
    protected $table = 'produk';

    // Tentukan primary key jika berbeda dari id
    protected $primaryKey = 'id_produk';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama_produk',
        'jenis_produk',
        'harga_produk',
        'foto_produk',
        'deskripsi_produk',
    ];

    // Tentukan jika ada kolom timestamps (created_at, updated_at)
    public $timestamps = true;

    // Tentukan jika ada kolom soft delete (deleted_at)
    protected $dates = ['deleted_at'];
}
