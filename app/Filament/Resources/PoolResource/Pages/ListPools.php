<?php

namespace App\Filament\Resources\PoolResource\Pages;

use App\Filament\Resources\PoolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconPosition;

class ListPools extends ListRecords
{
    protected static string $resource = PoolResource::class;

    protected ?string $heading = 'Survivor Pools';


    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Pools')
                ->icon('heroicon-m-user-group')
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
