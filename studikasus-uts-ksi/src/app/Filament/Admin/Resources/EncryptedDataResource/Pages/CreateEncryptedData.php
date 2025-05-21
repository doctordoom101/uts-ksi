<?php

namespace App\Filament\Admin\Resources\EncryptedDataResource\Pages;

use App\Filament\Admin\Resources\EncryptedDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEncryptedData extends CreateRecord
{
    protected static string $resource = EncryptedDataResource::class;
}
