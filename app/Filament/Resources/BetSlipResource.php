<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BetSlipResource\Pages;
use App\Filament\Resources\BetSlipResource\RelationManagers;
use App\Models\BetSlip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BetSlipResource extends Resource
{
    protected static ?string $model = BetSlip::class;

    protected static ?string $navigationGroup = 'Fun';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Betslips';

    protected static ?string $pluralModelLabel = 'Betslips';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bet_type')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('league_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('sport')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('game_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('selection_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('unscheduled_event')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('unscheduled_option')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('odds')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bet_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('result'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Bettor')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type.value')
                    ->label('Bet Type')
                    ->sortable(),

                Tables\Columns\TextColumn::make('league.name')
                    ->searchable()
                    ->label('League')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sport')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('game_id')
                    ->label('Game ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pick.name')
                    ->label('Selection')
                    ->searchable(),

                Tables\Columns\TextColumn::make('unscheduled_event')
                    ->searchable()
                    ->label('Unofficial Event'),

                Tables\Columns\TextColumn::make('unscheduled_option')
                    ->searchable()
                    ->label('Unofficial Selection'),

                Tables\Columns\TextColumn::make('odds')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('bet_amount')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\IconColumn::make('result')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBetSlips::route('/'),
            'create' => Pages\CreateBetSlip::route('/create'),
            'edit' => Pages\EditBetSlip::route('/{record}/edit'),
        ];
    }
}
