<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'no_hp', 'periode_awal', 'periode_akhir', 'foto', 'id_level_member'
    ];

    public function levelmember()
    {
        return $this->belongsTo(LevelMember::class, 'id_level_member', 'id_level_member');
    }
}
