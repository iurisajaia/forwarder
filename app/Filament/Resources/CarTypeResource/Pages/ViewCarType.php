<?php

namespace App\Filament\Resources\CarTypeResource\Pages;

use App\Filament\Resources\CarTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCarType extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = CarTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\EditAction::make(),
        ];
    }
}
