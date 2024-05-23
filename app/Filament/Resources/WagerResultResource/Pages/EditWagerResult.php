<?php

namespace App\Filament\Resources\WagerResultResource\Pages;

use App\Filament\Resources\WagerResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWagerResult extends EditRecord
{
    protected static string $resource = WagerResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
