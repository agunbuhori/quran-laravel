<?php

namespace App\Filament\Resources\LearnResource\Pages;

use App\Filament\Resources\LearnResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLearns extends ListRecords
{
    protected static string $resource = LearnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
