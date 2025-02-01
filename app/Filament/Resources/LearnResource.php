<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LearnResource\Pages;
use App\Filament\Resources\LearnResource\RelationManagers;
use App\Filament\Resources\LearnResource\RelationManagers\LearnsRelationManager;
use App\Models\Learn;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LearnResource extends Resource
{
    protected static ?string $model = Learn::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tag')->required(),
                TextInput::make('title')->required(),
                TextInput::make('youtube_id'),
                Select::make('type')->options([
                    'ebook' => 'Ebook',
                    'youtube' => 'Youtube',
                    'audio' => 'Audio',
                ]),
                FileUpload::make('link')->disk('ctb')
                                ->disk('ctb')
                                ->directory('uploads')
                                ->visibility('private'),
                FileUpload::make('thumbnail')
                                ->image()
                                ->disk('ctb')
                                ->directory('uploads')
                                ->visibility('private'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
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
            LearnsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLearns::route('/'),
            'create' => Pages\CreateLearn::route('/create'),
            'edit' => Pages\EditLearn::route('/{record}/edit'),
        ];
    }
}
