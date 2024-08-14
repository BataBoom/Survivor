<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Filament\Resources\UsersResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UsersResource\RelationManagers\PoolsRelationManager;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'General';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label('Email Verified')
                    //->default(now())
                    ->nullable(),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => !empty($state))
                    //->default(Auth::user()->password)
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')->label('Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->since()->sortable(),
                Tables\Columns\TextColumn::make('email_verified_at')->label('Verified')->since()->sortable(),
                /*
                Tables\Columns\TextColumn::make('survivorpools_count')
                ->label('Survivor Tix')
                ->counts('survivorpools')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('pickempools_count')
                ->label('Pickem Tix')
                ->counts('pickempools')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('mypicks_count')
                ->label('Survivor Picks')
                ->counts('mypicks')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('mypickems_count')
                ->label('Pickem Picks')
                ->counts('mypickems')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
                */
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
            RelationManagers\PoolsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
        ];
    }
}
