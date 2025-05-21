<?php

namespace App\Models;

use Illuminate\Support\Str;
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

    protected static function boot(){
        parent::boot();

        static::creating(function ($guru) {
            $guru->api_token = Str::random(5);
            });
        }  

    public function jadwalMengajar(): HasMany
    {
        return $this->hasMany(JadwalMengajar::class);
    }
}