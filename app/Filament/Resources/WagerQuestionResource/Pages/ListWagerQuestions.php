<?php

namespace App\Filament\Resources\WagerQuestionResource\Pages;

use App\Filament\Resources\WagerQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconPosition;

class ListWagerQuestions extends ListRecords
{
    protected static string $resource = WagerQuestionResource::class;

    protected ?string $heading = 'Scheduled Games';


    protected static ?string $navigationLabel = 'Games';

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('NFL Schedule')
                ->icon('heroicon-s-clipboard')
                ->iconPosition(IconPosition::After),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
