<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WagerQuestionResource\Pages;
use App\Filament\Resources\WagerQuestionResource\RelationManagers;
use App\Models\WagerQuestion;
use App\Models\WagerTeam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Model;

class WagerQuestionResource extends Resource
{
    protected static ?string $navigationGroup = 'Survivor';

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
                Tables\Columns\TextColumn::make('game_id')
                ->label('GameID')
                ->toggleable(isToggledHiddenByDefault: false)
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('week')
                ->label('Week')
                ->sortable()
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('question')
                ->label('Game')
                ->searchable()
                ->alignment(Alignment::Center)
                ->size(TextColumn\TextColumnSize::ExtraSmall),

                Tables\Columns\TextColumn::make('starts_at')->since()->label('Starts')->sortable()->alignment(Alignment::Center),

                Tables\Columns\IconColumn::make('ended')
                    ->label('Concluded')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->sortable()
                    ->alignment(Alignment::Center)
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('results.winner_name')->label('Winner')->alignment(Alignment::Center),
                    /*
                    Tables\Columns\SelectColumn::make('results.winner_name')
                        ->label('Winner')
                        ->alignment(Alignment::Center)
                        ->options(function (Model $record): array {
                            return $record->gameoptions->pluck('option',  'team_id')->toArray();
                        })
                        ->placeholder(function (Model $record): string {
                            return $record->results?->winner_name;
                        }),
                    */
                        

            ])->defaultSort('week', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('week')
                        ->multiple()
                        ->options(array_combine(range(1,18), range(1,18))),
                /*
                Tables\Filters\SelectFilter::make('question.options')
                        ->label('Teams')
                        ->multiple()
                        ->options(WagerTeam::all()->pluck('name', 'team_id')->toArray())
                        ->query(function ($query, array $data) {
                            if (!empty($data['team_id'])) {
                                $query->whereIn('team_id', $data['team_id']);
                            }
                        }),
                */
                Tables\Filters\TernaryFilter::make('ended')
                    ->label('Concluded')
                    ->nullable()
                    ->attribute('ended'),

            ], layout: FiltersLayout::AboveContent)
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
