<?php

namespace App\Filament\Resources\CarTypeResource\Pages;

use App\Filament\Resources\CarTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCarType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = CarTypeResource::class;


    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
