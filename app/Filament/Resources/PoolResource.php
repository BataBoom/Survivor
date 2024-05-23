<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoolResource\Pages;
use App\Filament\Resources\PoolResource\RelationManagers;
use App\Models\Pool;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PoolResource extends Resource
{
    protected static ?string $model = Pool::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Survivor Pools';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('type')->label('Type')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('entry_cost')->label('Entry Fee')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lives_per_person')->label('Lives')->sortable(),
                Tables\Columns\TextColumn::make('prize_type')->label('Prize Type')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Users'),
                Tables\Columns\TextColumn::make('survivors_count')
                    ->counts('survivors')
                    ->label('Survivors'),
            ])->defaultSort('survivors_count', 'desc')
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
            'index' => Pages\ListPools::route('/'),
            'create' => Pages\CreatePool::route('/create'),
            'edit' => Pages\EditPool::route('/{record}/edit'),
        ];
    }
}
