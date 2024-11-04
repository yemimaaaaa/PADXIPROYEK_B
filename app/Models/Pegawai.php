<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model implements AuthenticatableContract
{
    use Authenticatable, SoftDeletes;

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
        'id_role'
    ];

    // Tentukan jika ada kolom soft delete
    protected $dates = ['deleted_at'];

    // Menyediakan timestamps secara otomatis
    public $timestamps = true;

    public function isPegawai()
    {
        return $this->role === 'pegawai';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}