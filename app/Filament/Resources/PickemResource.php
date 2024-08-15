<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PickemResource\Pages;
use App\Filament\Resources\PickemResource\RelationManagers;
use App\Models\Pickem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;

class PickemResource extends Resource
{
    protected static ?string $model = Pickem::class;

    protected static ?string $navigationGroup = 'Pickem';

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';

    protected static ?string $navigationLabel = "Pick'em";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_id')
                ->label('User ID')
                ->disabled(),

                TextInput::make('week')
                ->label('Week')
                ->disabled(),

                TextInput::make('selection')
                ->label('Selection')
                ->disabled(),

                TextInput::make('ticket_id')
                ->label('Pool Ticket ID')
                ->disabled(),

                Toggle::make('result')
                    ->label('Result')
                    ->onColor('success')
                    ->offColor('danger')
                    ->helperText('Game cannot be graded until game has finished. Danger grading games from here, in development')
                    ->disabled(function (Pickem $record): bool {
                        // Check if the 'ended' attribute is not null
                        //return $get('ended') !== null;
                        return $record->question->ended == false;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->toggleable(isToggledHiddenByDefault: true)
                ->size(TextColumn\TextColumnSize::ExtraSmall)
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('ticket_id')
                ->label('Pool Ticket #')
                ->toggleable(isToggledHiddenByDefault: true)
                ->size(TextColumn\TextColumnSize::ExtraSmall)
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('pool.pool.name')
                ->label('Pool')
                ->alignment(Alignment::Center)
                ->color('info')
                ->icon('heroicon-s-arrow-top-right-on-square')
                ->url(fn (Pickem $record): ?string => $record ? route('pool.show', $record->pool->pool_id) : null)
                ->openUrlInNewTab(),


                Tables\Columns\TextColumn::make('question.question')
                ->label('Game')
                ->size(TextColumn\TextColumnSize::ExtraSmall)
                ->alignment(Alignment::Center),

                Tables\Columns\TextColumn::make('user.name')->sortable(),
                Tables\Columns\TextColumn::make('selection')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('week'),
                Tables\Columns\IconColumn::make('result')
                ->boolean(),
            ])->defaultSort('week', 'asc')
            ->filters([
                    SelectFilter::make('pool')
                        ->relationship('pool.pool', 'name', fn (Builder $query) => $query->where('type', 'pickem'))
                        ->searchable()
                        ->preload(),
                    

                    SelectFilter::make('player')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload(),
                    SelectFilter::make('week')
                        ->multiple()
                        ->options(array_combine(range(1,18), range(1,18))),
                    TernaryFilter::make('result')
                        ->nullable()
                        ->placeholder('All')
                        ->trueLabel('Won')
                        ->falseLabel('Lost'),

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
            'index' => Pages\ListPickems::route('/'),
            'create' => Pages\CreatePickem::route('/create'),
            'edit' => Pages\EditPickem::route('/{record}/edit'),
        ];
    }
}