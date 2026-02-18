<?php

namespace App\Filament\Resources\BetSlipResource\Pages;

use App\Filament\Resources\BetSlipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBetSlips extends ListRecords
{
    protected static string $resource = BetSlipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
