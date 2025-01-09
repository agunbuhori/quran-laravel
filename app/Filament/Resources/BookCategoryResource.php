<?php

namespace App\Filament\Resources;

use App\Enums\Lang;
use App\Filament\Resources\BookCategoryResource\Pages;
use App\Filament\Resources\BookCategoryResource\RelationManagers;
use App\Models\BookCategory;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookCategoryResource extends Resource
{
    protected static ?string $model = BookCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Repeater::make('translations')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        Select::make('lang')
                            ->label('Language')
                            ->options([
                                Lang::ID->value => 'Indonesian',
                                Lang::MS->value => 'Malay',
                                Lang::TH->value => 'Thai',
                                Lang::VI->value => 'Vietnamese',
                            ])
                            ->required(),
                    ])->relationship('translations')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBookCategories::route('/'),
        ];
    }
}
