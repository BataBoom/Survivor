<?php

namespace App\Filament\Resources\PickemResource\Pages;

use App\Filament\Resources\PickemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPickem extends EditRecord
{
    protected static string $resource = PickemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
