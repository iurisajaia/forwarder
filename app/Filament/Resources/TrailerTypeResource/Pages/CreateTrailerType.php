<?php

namespace App\Filament\Resources\TrailerTypeResource\Pages;

use App\Filament\Resources\TrailerTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrailerType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = TrailerTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make()
        ];
    }
}
