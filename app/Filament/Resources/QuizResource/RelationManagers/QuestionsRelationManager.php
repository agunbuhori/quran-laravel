<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('question')->columnSpan(2)
                    ->required()
                    ->label('Pertanyaan')
                    ->fileAttachmentsDisk('ctb')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('questions'),
                TextInput::make('correct_weight')->default(3)->numeric()->label('Bobot jika benar')->maxValue(3)->required(),
                TextInput::make('wrong_weight')->default(-1)->numeric()->label('Bobot jika salah')->maxValue(0)->required(),
                Repeater::make('answers')->schema([
                    RichEditor::make('answer')
                        ->label('Jawaban')
                        ->required()
                        ->extraInputAttributes(['style' => 'min-height: 5rem; max-height: 10vh; overflow-y: auto;'])
                        ->fileAttachmentsDisk('ctb')
                        ->fileAttachmentsVisibility('public')
                        ->fileAttachmentsDirectory('questions'),
                    Toggle::make('correct')->label('Jawaban ini benar'),
                ])
                    ->columnSpan(2)
                    ->minItems(2)
                    ->defaultItems(2)
                    ->label('Jawaban-jawaban')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('questions')
            ->columns([
                Tables\Columns\TextColumn::make('question')->html(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()->recordTitleAttribute('question')->preloadRecordSelect()
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
