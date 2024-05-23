<?php

namespace App\Filament\Resources\WagerTeamResource\Pages;

use App\Filament\Resources\WagerTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWagerTeam extends EditRecord
{
    protected static string $resource = WagerTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
