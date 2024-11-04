<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'role';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_role';
    public $incrementing = true;

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama_role',
    ];

    protected $dates = ['deleted_at'];
    // Menyediakan timestamps secara otomatis
    public $timestamps = true;
}
