<?php

namespace App\Filament\Resources\SurvivorResource\Pages;

use App\Filament\Resources\SurvivorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconPosition;
class ListSurvivors extends ListRecords
{
    protected static string $resource = SurvivorResource::class;

    protected ?string $heading = 'Survivor 2024';

    protected ?string $subheading = 'All picks from all pools';
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Survivor')
                ->icon('heroicon-m-fire')
                ->iconPosition(IconPosition::After),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }
}
