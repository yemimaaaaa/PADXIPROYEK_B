<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LevelMember extends Model
{
    use SoftDeletes;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'levelmember';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_level_member';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'tingkatan_level',
        'poin_minimal',
        'diskon',
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
