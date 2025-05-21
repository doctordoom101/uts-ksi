<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function cetakJadwal(Request $request)
    {
        $guru_id = $request->input('guru_id');
        $hari = $request->input('hari');
        
        $query = JadwalMengajar::with(['guru', 'mapel', 'kelas']);
        
        if ($guru_id) {
            $query->where('guru_id', $guru_id);
        }
        
        if ($hari) {
            $query->where('hari', $hari);
        }
        
        $jadwals = $query->orderBy('hari')->orderBy('jam_mulai')->get();
        $gurus = Guru::orderBy('nama')->get();
        
        return view('admin.laporan.jadwal', compact('jadwals', 'guru', 'guru_id', 'hari'));
    }
}