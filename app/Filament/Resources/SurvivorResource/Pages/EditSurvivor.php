<?php

namespace App\Filament\Resources\SurvivorResource\Pages;

use App\Filament\Resources\SurvivorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditSurvivor extends EditRecord
{
    use InteractsWithRecord;

    protected static string $resource = SurvivorResource::class;

    //protected static ?string $title = $record->id;

    protected static string $view = 'filament.admin.resources.survivor-resource.pages.edit-survivor';

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }

    public function getExtraBodyAttributes(): array
    {
        return [
            'class' => '',
        ];
    }

    public function getSubheading(): ?string
    {   
        return $this->record->id;
    }
}
