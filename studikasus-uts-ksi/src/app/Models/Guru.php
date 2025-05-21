<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'no_telepon',
        'alamat',
    ];

    public function jadwalMengajar(): HasMany
    {
        return $this->hasMany(JadwalMengajar::class);
    }
}