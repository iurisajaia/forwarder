<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListCars extends ListRecords
{
    protected static string $resource = CarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('number')
                        ->label('Number'),
                    ImportField::make('title')
                        ->label('Title'),
                    ImportField::make('model')
                        ->label('Model'),
                    ImportField::make('car_type_id')
                        ->label('Type'),
                    ImportField::make('identification_number')
                        ->label('Identification Number'),

                ])
        ];
    }
}
