<?php

namespace App\Filament\Resources\TrailerTypeResource\Pages;

use App\Filament\Resources\TrailerTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrailerType extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TrailerTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
