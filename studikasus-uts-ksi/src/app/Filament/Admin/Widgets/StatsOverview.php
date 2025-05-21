<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\Mapel;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Guru', Guru::count())
                ->description('Jumlah guru terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
                
            Stat::make('Total Mata Pelajaran', Mapel::count())
                ->description('Jumlah mata pelajaran')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),
                
            Stat::make('Total Kelas', Kelas::count())
                ->description('Jumlah kelas')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning'),
                
            Stat::make('Total Jadwal', JadwalMengajar::count())
                ->description('Jumlah jadwal mengajar')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('danger'),
        ];
    }
}