<?php

namespace App\Filament\Resources\WagerResultResource\Pages;

use App\Filament\Resources\WagerResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconPosition;

class ListWagerResults extends ListRecords
{
    protected static string $resource = WagerResultResource::class;

    protected static ?string $navigationLabel = 'Game Results';
    protected ?string $heading = 'Browsing Results';



    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Game Results')
                ->icon('heroicon-s-check')
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
