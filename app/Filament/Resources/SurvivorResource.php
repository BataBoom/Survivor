<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurvivorResource\Pages;
use App\Filament\Resources\SurvivorResource\RelationManagers;
use App\Models\Survivor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurvivorResource extends Resource
{
    protected static ?string $model = Survivor::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

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
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('pool_id')->sortable(),
                Tables\Columns\TextColumn::make('game_id'),
                Tables\Columns\TextColumn::make('user_id')->sortable(),
                Tables\Columns\TextColumn::make('selection')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('week'),
                Tables\Columns\TextColumn::make('result'),
                Tables\Columns\TextColumn::make('league')->searchable(),
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
            'index' => Pages\ListSurvivors::route('/'),
            'create' => Pages\CreateSurvivor::route('/create'),
            'edit' => Pages\EditSurvivor::route('/{record}/edit'),
        ];
    }
}
