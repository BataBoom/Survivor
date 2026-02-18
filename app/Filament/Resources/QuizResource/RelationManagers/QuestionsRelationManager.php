<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Repeater::make('options')
                ->label('Options')
                ->relationship('options')
                ->schema([
                     Forms\Components\TextInput::make('option')
                        ->required()
                        ->label('Option'),
                    Forms\Components\Toggle::make('answer')
                            ->default(false)
                            ->required()
                            ->label('is Answer'),
                    // Other fields for option if needed
                ])
                ->defaultItems(2) // Creates one empty option by default
                ->createItemButtonLabel('Add Option')
                ->reorderable()
                ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                Tables\Columns\TextColumn::make('question'),
                Tables\Columns\TextColumn::make('options.option') // Assuming 'name' is an attribute in the options model
                ->label('Option Name')
                ->words(8),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form([
                    Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(255),

                    Forms\Components\Repeater::make('options')
                    ->label('Options')
                    ->relationship('options')
                    ->schema([
                        Forms\Components\TextInput::make('option')
                            ->required()
                            ->label('Option'),
                        Forms\Components\Toggle::make('answer')
                            ->default(false)
                            ->required()
                            ->label('is Answer'),
                        // Other fields for option if needed
                    ])
                    ->defaultItems(1) // Creates one empty option by default
                    ->createItemButtonLabel('Add Option')
                    ->reorderable(),
                ]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
