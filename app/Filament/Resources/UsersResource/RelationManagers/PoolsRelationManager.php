<?php

namespace App\Filament\Resources\UsersResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class PoolsRelationManager extends RelationManager
{
    protected static string $relationship = 'pools';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('alive')
                    ->required()
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('pool.name')
                ->color('info')
                ->icon('heroicon-s-arrow-top-right-on-square')
                ->url(fn (Model $record): ?string => $record ? route('pool.show', $record->pool->id) : null)
                ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('pool.type')
                ->formatStateUsing(fn (string $state) => ucwords($state)),
                
                Tables\Columns\TextColumn::make('picks_count')
                ->label('Picks')
                ->counts('picks'),

                Tables\Columns\IconColumn::make('alive')
                ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
