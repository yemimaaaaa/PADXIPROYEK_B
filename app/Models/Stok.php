<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stok extends Model
{
    use SoftDeletes;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'stok';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_stok';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama_stok',
        'jenis_stok',              
        'tanggal_masuk_stok',       
        'foto_stok',
        'deskripsi_stok',
        'id_pegawai'
    ];

    // Tentukan jika ada kolom soft delete
    protected $dates = ['deleted_at'];

    // Menyediakan timestamps secara otomatis
    public $timestamps = true;

    // Relasi ke Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai'); // Relasi ke model Pegawai
    }
}
