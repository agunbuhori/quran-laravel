<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\Select;

class CustomSelects
{
    public static function learnTags(): Select 
    {
        return Select::make('tag')->options([
            'tafsir' => 'Tafsir At-Taysir'
        ])->required();
    }
}