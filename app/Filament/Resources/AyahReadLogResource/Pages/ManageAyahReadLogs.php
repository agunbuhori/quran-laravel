<?php

namespace App\Filament\Resources\AyahReadLogResource\Pages;

use App\Filament\Resources\AyahReadLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAyahReadLogs extends ManageRecords
{
    protected static string $resource = AyahReadLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
