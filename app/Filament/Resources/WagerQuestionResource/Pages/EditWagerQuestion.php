<?php

namespace App\Filament\Resources\WagerQuestionResource\Pages;

use App\Filament\Resources\WagerQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWagerQuestion extends EditRecord
{
    protected static string $resource = WagerQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
