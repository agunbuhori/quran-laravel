<?php

namespace App\Filament\Resources;

use App\Filament\Forms\CustomSelects;
use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Filament\Resources\QuizResource\RelationManagers\QuestionsRelationManager;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';
    protected static ?string $navigationGroup = 'Kuis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                CustomSelects::learnTags(),
                TextInput::make('title')->required(),
                TextInput::make('total_questions')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->label('Jumlah soal'),
                Select::make('status')
                    ->options([
                        'draft'         => 'Draft',
                        'published'     => 'Dipublikasi',
                        'unpublished'   => 'Non-aktif'
                    ])
                    ->required()
                    ->default('draft'),
                Select::make('duration')->options([
                    2 => "2 menit",
                    5 => "5 menit",
                    10 => "10 menit",
                    15 => "15 menit",
                    20 => "20 menit",
                    30 => "30 menit",
                    60 => "60 menit",
                    90 => "90 menit",
                    120 => "120 menit"
                ])->required()
                ->label('Durasi'),
                Textarea::make('description')
                    ->nullable()
                    ->label('Deskripsi'),
                DateTimePicker::make('closed_at')->minDate(now())->label('Ditutup pada'),
                DateTimePicker::make('announced_at')->minDate(now())->label('Pengumuman nilai'),
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
            QuestionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
