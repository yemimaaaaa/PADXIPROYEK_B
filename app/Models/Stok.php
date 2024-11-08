<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stok extends Model
{
    use SoftDeletes;

    protected $table = 'stok'; // Nama tabel custom
    protected $primaryKey = 'id_stok'; // Primary key custom

    protected $fillable = [
        'nama_stok',
        'jenis_stok',              
        'tanggal_masuk_stok',       
        'foto_stok',
        'deskripsi_stok',
        'id_pegawai'
    ];

    // Tidak perlu mendeklarasikan deleted_at sejak Laravel 8+
    protected $dates = ['deleted_at'];

    public $timestamps = true; // Mengaktifkan timestamps

    /**
     * Relasi ke tabel Pegawai
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
