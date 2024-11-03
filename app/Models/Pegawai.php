<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'pegawai';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_pegawai';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama_pegawai',
        'username',
        'password',
        'nohp_pegawai',
        'email_pegawai',
        'id_role' // Menambahkan id_levelmember jika akan digunakan dalam relasi
    ];

    // Tentukan jika ada kolom soft delete
    protected $dates = ['deleted_at'];

    // Menyediakan timestamps secara otomatis
    public $timestamps = true;

    // Relasi ke LevelMember
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role'); // Relasi ke LevelMember
    }

    // Relasi ke Member lain jika ada (jika Member memiliki relasi dengan Member lain, misal sebagai grup)
    // Jika ini adalah relasi yang valid, namanya harus berbeda

}
