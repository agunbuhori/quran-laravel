<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UstadzResource\Pages;
use App\Filament\Resources\UstadzResource\RelationManagers;
use App\Models\Ustadz;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UstadzResource extends Resource
{
    protected static ?string $model = Ustadz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('front_degree'),
                TextInput::make('back_degree'),
                Radio::make('gender')->options([
                    'male' => 'Ikhwan',
                    'female' => 'Akhwat'
                ])->default('male')->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUstadzs::route('/'),
            'create' => Pages\CreateUstadz::route('/create'),
            'edit' => Pages\EditUstadz::route('/{record}/edit'),
        ];
    }
}
