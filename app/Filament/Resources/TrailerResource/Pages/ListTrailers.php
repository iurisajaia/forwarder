<?php

namespace App\Filament\Resources\TrailerResource\Pages;

use App\Filament\Resources\TrailerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrailers extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = TrailerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
