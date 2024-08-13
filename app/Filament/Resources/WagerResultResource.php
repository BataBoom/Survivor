<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WagerResultResource\Pages;
use App\Filament\Resources\WagerResultResource\RelationManagers;
use App\Models\WagerResult;
use App\Models\WagerTeam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\IconColumn;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Enums\FiltersLayout;

class WagerResultResource extends Resource
{
    protected static ?string $model = WagerResult::class;

    protected static ?string $navigationGroup = 'Survivor';

    protected static ?string $navigationIcon = 'heroicon-o-check';

    protected static ?string $navigationLabel = 'Game Results';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('game')->label('Game ID')->required(),
                TextInput::make('winner_name')->label('Winner')->required(),
                TextInput::make('winner')->label('Winner ID')->required(),
                TextInput::make('home_score')->label('Home Score')->required(),
                TextInput::make('away_score')->label('Away Score')->required(),
                Forms\Components\Toggle::make('question.ended')->label('Ended'),


                //Checkbox::make('question.ended')->label('Ended'),
                //Checkbox::make('question.status')->label('Scheduled')->default(false),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('game')->label('GameID')->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('week')->label('Week')->sortable(),
                Tables\Columns\TextColumn::make('question.question')->label('Game')->searchable(),
                Tables\Columns\TextColumn::make('winner_name')->label('Winner')->sortable(),
                Tables\Columns\TextColumn::make('winner')->label('Winner ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('home_score')->label('Home')->sortable()->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('away_score')->label('Away')->sortable()->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('question.starts_at')->since()->label('Starts')->sortable()->toggleable(isToggledHiddenByDefault: false),


                Tables\Columns\BooleanColumn::make('question.ended')
                    ->label('Concluded')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->alignment(Alignment::Center),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('week')
                        ->multiple()
                        ->options(array_combine(range(1,18), range(1,18))),
                Tables\Filters\SelectFilter::make('winner_name')
                        ->label('Team Winner')
                        ->multiple()
                        ->options(WagerTeam::All()->pluck('name',  'name')->toArray()),

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
            'index' => Pages\ListWagerResults::route('/'),
            'create' => Pages\CreateWagerResult::route('/create'),
            'edit' => Pages\EditWagerResult::route('/{record}/edit'),
        ];
    }
}
