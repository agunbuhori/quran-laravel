<?php

namespace App\Filament\Resources\LearnResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LearnsRelationManager extends RelationManager
{
    protected static string $relationship = 'learns';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make('tag')->required(),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
