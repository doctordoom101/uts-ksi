<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jadwal Mengajar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .filter-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .print-button {
            margin-top: 20px;
            text-align: center;
        }
        @media print {
            .filter-section, .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>Laporan Jadwal Mengajar</h1>
    
    <div class="filter-section">
        <form action="{{ route('admin.jadwal.cetak') }}" method="GET">
            <div style="display: flex; gap: 15px; margin-bottom: 10px;">
                <div style="flex: 1;">
                    <label for="guru_id">Guru:</label>
                    <select name="guru_id" id="guru_id" style="width: 100%; padding: 8px;">
                        <option value="">-- Semua Guru --</option>
                        @foreach($guru as $guru)
                            <option value="{{ $guru->id }}" {{ $guru_id == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }} ({{ $guru->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1;">
                    <label for="hari">Hari:</label>
                    <select name="hari" id="hari" style="width: 100%; padding: 8px;">
                        <option value="">-- Semua Hari --</option>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                            <option value="{{ $h }}" {{ $hari == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Filter
            </button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Guru</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Jam</th>
            </tr>
        </thead>
        <tbody>
            @if($jadwals->count() > 0)
                @foreach($jadwals as $index => $jadwal)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jadwal->guru->nama }}</td>
                        <td>{{ $jadwal->mapel->nama_mapel }}</td>
                        <td>{{ $jadwal->kelas->nama_kelas }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data jadwal yang ditemukan</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="print-button">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #008CBA; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Cetak Laporan
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>
</body>
</html>