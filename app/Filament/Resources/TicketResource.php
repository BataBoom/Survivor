<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
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

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationGroup = 'General';

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?string $navigationLabel = "Support";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('user_id')
                    ->label('user_id')
                    ->disabled(),

                Forms\Components\TextInput::make('subject')
                    ->label('Subject')
                    ->disabled(),

                Forms\Components\Toggle::make('answered')
                    ->label('Answered')
                    ->onColor('success')
                    ->offColor('danger'),

                Forms\Components\Toggle::make('resolved')
                    ->label('Resolved')
                    ->onColor('success')
                    ->offColor('danger'),
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

                Tables\Columns\TextColumn::make('user.name')->sortable()->searchable(),

                Tables\Columns\TextColumn::make('subject')
                ->label('Subject')
                ->alignment(Alignment::Center)
                ->color('info')
                ->icon('heroicon-s-arrow-top-right-on-square')
                ->url(fn (Ticket $record): ?string => $record ? route('support.show', $record->id) : null)
                ->openUrlInNewTab(),


                Tables\Columns\TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('Replies')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable()
                    ->alignment(Alignment::Center),

                Tables\Columns\IconColumn::make('answered')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),

                Tables\Columns\IconColumn::make('resolved')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),

                Tables\Columns\TextColumn::make('payment.id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->since(),

            ])->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
