<?php

namespace App\Filament\Resources\UserRoleResource\Pages;

use App\Filament\Resources\UserRoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserRole extends EditRecord
{
    protected static string $resource = UserRoleResource::class;

    use EditRecord\Concerns\Translatable;


    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),

        ];
    }
}
