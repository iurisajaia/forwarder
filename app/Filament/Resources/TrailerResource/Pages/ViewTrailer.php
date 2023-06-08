<?php

namespace App\Filament\Resources\TrailerResource\Pages;

use App\Filament\Resources\TrailerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTrailer extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = TrailerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\EditAction::make(),
        ];
    }
}
