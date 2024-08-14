<?php

namespace App\Filament\Resources\PickemResource\Pages;

use App\Filament\Resources\PickemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPickems extends ListRecords
{
    protected static string $resource = PickemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
