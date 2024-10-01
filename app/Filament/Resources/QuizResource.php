<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\Alignment;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationGroup = 'Fun';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Quizes';

    protected static ?string $pluralModelLabel = 'Quizes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric()
                    ->default(1),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Quiz')
                    ->alignment(Alignment::Center)
                    ->color('info')
                    ->icon('heroicon-s-arrow-top-right-on-square')
                    ->url(fn (Quiz $record): ?string => $record ? route('quiz.show', $record->slug) : null)
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Creator'),

                Tables\Columns\TextColumn::make('questions_count')
                    ->label('Questions')
                    ->counts('questions')
                    ->sortable(),

                Tables\Columns\TextColumn::make('scores_count')
                    ->label('Test Takers')
                    ->counts('scores')
                    ->sortable(),

                Tables\Columns\TextColumn::make('score_percentage')
                    ->label('Average Score (%)')
                    ->getStateUsing(function ($record) {
                        // Assuming 'scores' is the relationship name where each score has a 'percentage' field
                        return $record->scores->avg('percentage');
                    })
                    ->formatStateUsing(fn ($state) => number_format($state, 2)), 

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
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
             RelationManagers\QuestionsRelationManager::class,
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
