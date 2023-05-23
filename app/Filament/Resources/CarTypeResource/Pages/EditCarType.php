<?php

namespace App\Filament\Resources\CarTypeResource\Pages;

use App\Filament\Resources\CarTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarType extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CarTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
