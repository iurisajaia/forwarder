<?php

namespace App\Filament\Resources\CarTypeResource\Pages;

use App\Filament\Resources\CarTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarTypes extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = CarTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
