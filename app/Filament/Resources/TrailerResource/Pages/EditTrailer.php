<?php

namespace App\Filament\Resources\TrailerResource\Pages;

use App\Filament\Resources\TrailerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrailer extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TrailerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
