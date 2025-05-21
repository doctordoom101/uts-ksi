<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalMengajar extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    // Custom method untuk mengecek jadwal bentrok guru
    public static function isJadwalBentrokGuru($guru_id, $hari, $jam_mulai, $jam_selesai, $kecuali_id = null)
    {
        $query = self::where('guru_id', $guru_id)
            ->where('hari', $hari)
            ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                $query->whereBetween('jam_mulai', [$jam_mulai, $jam_selesai])
                    ->orWhereBetween('jam_selesai', [$jam_mulai, $jam_selesai])
                    ->orWhere(function ($q) use ($jam_mulai, $jam_selesai) {
                        $q->where('jam_mulai', '<=', $jam_mulai)
                            ->where('jam_selesai', '>=', $jam_selesai);
                    });
            });

        if ($kecuali_id) {
            $query->where('id', '!=', $kecuali_id);
        }

        return $query->exists();
    }

    // Custom method untuk mengecek jadwal bentrok kelas
    public static function isJadwalBentrokKelas($kelas_id, $hari, $jam_mulai, $jam_selesai, $kecuali_id = null)
    {
        $query = self::where('kelas_id', $kelas_id)
            ->where('hari', $hari)
            ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                $query->whereBetween('jam_mulai', [$jam_mulai, $jam_selesai])
                    ->orWhereBetween('jam_selesai', [$jam_mulai, $jam_selesai])
                    ->orWhere(function ($q) use ($jam_mulai, $jam_selesai) {
                        $q->where('jam_mulai', '<=', $jam_mulai)
                            ->where('jam_selesai', '>=', $jam_selesai);
                    });
            });

        if ($kecuali_id) {
            $query->where('id', '!=', $kecuali_id);
        }

        return $query->exists();
    }
}