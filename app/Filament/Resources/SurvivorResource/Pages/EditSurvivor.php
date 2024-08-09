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

    public function getTitle(): string | Htmlable
    {   
        return $this->record->id.': '.$this->record->question->question;
    
    }

    public function getSubheading(): ?string
    {   
        $subHeader = $this->record->question->question.' Ended: '.$this->record->question->ended ? 'Yes' : 'No';
        return $subHeader;
        if($this->record->question->ended == false) {
            return "Scheduled Game";
        } elseif ($this->record->question->ended == true) {
            return "Game has ended";
        } else {
            return '';
        }
        
    }
}
