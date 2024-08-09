<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WagerTeamResource\Pages;
use App\Filament\Resources\WagerTeamResource\RelationManagers;
use App\Models\WagerTeam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Illuminate\Database\Eloquent\Model;

class WagerTeamResource extends Resource
{
    protected static ?string $model = WagerTeam::class;

    protected static ?string $navigationGroup = 'Survivor';

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Sports Teams';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('location'),
                Forms\Components\TextInput::make('abbreviation'),
                Forms\Components\TextInput::make('color'),
                Forms\Components\TextInput::make('altColor'),
                Select::make('league')
                    ->options([
                        'nfl' => 'NFL',
                        'mlb' => 'MLB',
                        'nba' => 'NBA',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->alignment(Alignment::Center)
                ->size(TextColumn\TextColumnSize::Large),

                Tables\Columns\TextColumn::make('location')->alignment(Alignment::Center),
                Tables\Columns\TextColumn::make('abbreviation')->alignment(Alignment::Center),
                Tables\Columns\ColorColumn::make('color')->alignment(Alignment::Center),
                Tables\Columns\ColorColumn::make('altColor')->alignment(Alignment::Center),
                
                Tables\Columns\TextColumn::make('league')
                ->formatStateUsing(fn (string $state): string => strtoupper($state))
                ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('wins_count')
                    ->counts('wins')
                    ->label('Wins')
                    ->sortable()
                    ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('losses_count')
                    ->label('Losses')
                    ->sortable()
                    ->alignment(Alignment::Center),

        
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
            'index' => Pages\ListWagerTeams::route('/'),
            'create' => Pages\CreateWagerTeam::route('/create'),
            'edit' => Pages\EditWagerTeam::route('/{record}/edit'),
        ];
    }
}
