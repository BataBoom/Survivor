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
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;

class PoolResource extends Resource
{
    protected static ?string $model = Pool::class;

    protected static ?string $navigationGroup = 'Survivor';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pools';

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
                Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->size(TextColumn\TextColumnSize::ExtraSmall)
                ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->searchable()
                ->size(TextColumn\TextColumnSize::Large)
                ->alignment(Alignment::Center)
                ->color('info')
                ->icon('heroicon-s-arrow-top-right-on-square')
                ->url(fn (Pool $record): ?string => $record ? route('pool.show', $record->id) : null)
                ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('type')
                ->label('Type')
                ->searchable()
                ->formatStateUsing(fn (string $state): string => ucfirst($state)) 
                ->alignment(Alignment::Center),
                
                Tables\Columns\TextColumn::make('entry_cost')
                ->label('Entry Fee')
                ->sortable()
                ->size(TextColumn\TextColumnSize::ExtraSmall)
                ->money('USD')
                ->toggleable(isToggledHiddenByDefault: false)
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('total_prize')
                ->label('Prize')
                ->size(TextColumn\TextColumnSize::ExtraSmall)
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('lives_per_person')
                ->label('Max Lives')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('prize_type')
                ->label('Prize Type')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Total Players')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('survivors_count')
                    ->counts('survivors')
                    ->label('Players Alive')
                    ->sortable()
                    ->alignment(Alignment::Center),

            ])->defaultSort('survivors_count', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                        ->multiple()
                        ->options(array_combine(Pool::TYPES, Pool::TYPES))
                        ->attribute('type'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
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
