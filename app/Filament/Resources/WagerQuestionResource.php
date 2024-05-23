<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WagerQuestionResource\Pages;
use App\Filament\Resources\WagerQuestionResource\RelationManagers;
use App\Models\WagerQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;

class WagerQuestionResource extends Resource
{
    protected static ?string $model = WagerQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?string $navigationLabel = 'Games';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('game_id')->label('GameID'),
                Tables\Columns\TextColumn::make('week')->label('Week')->sortable(),
                Tables\Columns\TextColumn::make('question')->label('Game')->searchable(),
                Tables\Columns\TextColumn::make('starts_at')->since()->label('Starts')->sortable(),
                Tables\Columns\IconColumn::make('ended')
                    ->label('has Ended')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->sortable(),
            ])->defaultSort('week', 'asc')
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
            'index' => Pages\ListWagerQuestions::route('/'),
            'create' => Pages\CreateWagerQuestion::route('/create'),
            'edit' => Pages\EditWagerQuestion::route('/{record}/edit'),
        ];
    }
}
