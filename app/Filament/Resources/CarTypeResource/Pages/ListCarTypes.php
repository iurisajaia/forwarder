<?php

namespace App\Filament\Resources\CarTypeResource\Pages;

use App\Filament\Resources\CarTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarTypes extends ListRecords
{
    protected static string $resource = CarTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
