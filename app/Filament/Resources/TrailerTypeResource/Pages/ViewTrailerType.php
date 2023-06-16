<?php

namespace App\Filament\Resources\TrailerTypeResource\Pages;

use App\Filament\Resources\TrailerTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTrailerType extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = TrailerTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\EditAction::make(),
        ];
    }
}
