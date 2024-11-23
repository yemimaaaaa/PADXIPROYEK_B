<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Member extends Model
{
    use SoftDeletes;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'member';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_member';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama',
        'no_hp',
        'periode_awal',
        'periode_akhir',
        'foto',
        'id_level_member' // Menambahkan id_levelmember jika akan digunakan dalam relasi
    ];

    // Tentukan jika ada kolom soft delete
    protected $dates = ['deleted_at'];

    // Menyediakan timestamps secara otomatis
    public $timestamps = true;

    // Relasi ke LevelMember
    public function levelmember()
    {
        return $this->belongsTo(LevelMember::class, 'id_level_member', 'id_level_member'); // Relasi ke LevelMember
    }
    public function getNamaLevelAttribute()
    {
        $levels = [
            1001 => 'Bronze',
            1002 => 'Silver',
            1003 => 'Gold',
        ];
    
        return $levels[$this->id_level_member]??'Unknown';
    }

    // Relasi ke Member lain jika ada (jika Member memiliki relasi dengan Member lain, misal sebagai grup)
    // Jika ini adalah relasi yang valid, namanya harus berbeda
    public function members()
    {
        return $this->hasMany(Member::class, 'id_level_member', 'id'); // Relasi ke anggota lain
    }
    public function poins()
    {
        return $this->hasMany(Poin::class, 'id_member', 'id_member');
    }
     
    public function updatePoin($poinDiterima)
    {
    $this->poin += $poinDiterima;
    $this->save();

    Log::info('Poin member diperbarui:', [
        'id_member' => $this->id_member,
        'poinDiterima' => $poinDiterima,
        'totalPoin' => $this->poin,
    ]);
}

}
