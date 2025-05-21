<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JadwalMengajarResource\Pages;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\Mapel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class JadwalMengajarResource extends Resource
{
    protected static ?string $model = JadwalMengajar::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    protected static ?string $navigationLabel = 'Jadwal Mengajar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('guru_id')
                    ->required()
                    ->relationship('guru', 'nama')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('mapel_id')
                    ->required()
                    ->relationship('mapel', 'nama_mapel')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('kelas_id')
                    ->required()
                    ->relationship('kelas', 'nama_kelas')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('hari')
                    ->required()
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                    ]),
                Forms\Components\TimePicker::make('jam_mulai')
                    ->required()
                    ->seconds(false),
                Forms\Components\TimePicker::make('jam_selesai')
                    ->required()
                    ->seconds(false)
                    ->after('jam_mulai'),
                ]);
    }

    public static function beforeCreate(Form $form, array $data): void
    {
        self::validateJadwal($data);
    }

    public static function beforeUpdate(Form $form, array $data, $record): void
    {
        self::validateJadwal($data, $record->id);
    }

    protected static function validateJadwal(array $data, ?int $recordId = null): void
    {
        $guru_id = $data['guru_id'];
        $kelas_id = $data['kelas_id'];
        $hari = $data['hari'];
        $jam_mulai = $data['jam_mulai'];
        $jam_selesai = $data['jam_selesai'];

        if (JadwalMengajar::isJadwalBentrokGuru($guru_id, $hari, $jam_mulai, $jam_selesai, $recordId)) {
            throw ValidationException::withMessages([
                'guru_id' => 'Guru sudah memiliki jadwal mengajar di waktu yang sama.',
            ]);
        }

        if (JadwalMengajar::isJadwalBentrokKelas($kelas_id, $hari, $jam_mulai, $jam_selesai, $recordId)) {
            throw ValidationException::withMessages([
                'kelas_id' => 'Kelas sudah memiliki jadwal pelajaran di waktu yang sama.',
            ]);
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('guru.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mapel.nama_mapel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hari')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jam_mulai')
                    ->time()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jam_selesai')
                    ->time()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('guru')
                    ->relationship('guru', 'nama')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                    ]),
                Tables\Filters\SelectFilter::make('mapel')
                    ->relationship('mapel', 'nama_mapel')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getActions(): array
    {
        return [
            Action::make('cetak_jadwal')
                ->label('Cetak Jadwal')
                ->icon('heroicon-o-printer')
                ->url(fn (): string => route('admin.jadwal.cetak'))
                ->openUrlInNewTab(),
        ];
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalMengajars::route('/'),
            'create' => Pages\CreateJadwalMengajar::route('/create'),
            'edit' => Pages\EditJadwalMengajar::route('/{record}/edit'),
        ];
    }    
}