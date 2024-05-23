<?php

namespace App\Filament\Resources\WagerTeamResource\Pages;

use App\Filament\Resources\WagerTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconPosition;

class ListWagerTeams extends ListRecords
{
    protected static string $resource = WagerTeamResource::class;
    protected ?string $heading = 'Cataloged Teams';


    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Wager Teams')
                ->icon('heroicon-m-star')
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
