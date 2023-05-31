<?php

namespace App\Filament\Resources\UserRoleResource\Pages;

use App\Filament\Resources\UserRoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserRoles extends ListRecords
{
    protected static string $resource = UserRoleResource::class;
    use ListRecords\Concerns\Translatable;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
