<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Filament\Support\Enums\IconPosition;

class ListUsers extends ListRecords
{
    protected static string $resource = UsersResource::class;

    protected ?string $heading = 'Browsing Users';

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Users')
                ->icon('heroicon-m-user-group')
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
