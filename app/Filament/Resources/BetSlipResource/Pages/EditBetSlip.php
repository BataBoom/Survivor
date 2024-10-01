<?php

namespace App\Filament\Resources\BetSlipResource\Pages;

use App\Filament\Resources\BetSlipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBetSlip extends EditRecord
{
    protected static string $resource = BetSlipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
