<?php

namespace App\Filament\Resources\TrailerResource\Pages;

use App\Filament\Resources\TrailerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListTrailers extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = TrailerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('number')
                        ->label('Number'),
                    ImportField::make('title')
                        ->label('Title'),
                    ImportField::make('model')
                        ->label('Model'),
                    ImportField::make('trailer_type_id')
                        ->label('Type'),
                    ImportField::make('identification_number')
                        ->label('Identification Number'),

                ])
        ];
    }
}
