<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use SoftDeletes;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'member';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_member';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama_member',
        'nohp_member',
        'periode_awal_member',
        'periode_akhir_member',
        'foto_member',
        'id_levelmember' // Menambahkan id_levelmember jika akan digunakan dalam relasi
    ];

    // Tentukan jika ada kolom soft delete
    protected $dates = ['deleted_at'];

    // Menyediakan timestamps secara otomatis
    public $timestamps = true;

    // Relasi ke LevelMember
    public function levelmember()
    {
        return $this->belongsTo(LevelMember::class, 'id_levelmember'); // Relasi ke LevelMember
    }

    // Relasi ke Member lain jika ada (jika Member memiliki relasi dengan Member lain, misal sebagai grup)
    // Jika ini adalah relasi yang valid, namanya harus berbeda
    public function members()
    {
        return $this->hasMany(Member::class, 'id_levelmember'); // Relasi ke anggota lain
    }
}
