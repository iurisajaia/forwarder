<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserRoleResource\Pages;
use App\Filament\Resources\UserRoleResource\RelationManagers;
use App\Models\UserRole;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class UserRoleResource extends Resource
{
    use Translatable;
    protected static ?string $model = UserRole::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getTranslatableLocales(): array
    {
        return ['eng', 'geo' , 'tur', 'rus'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('key')->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserRoles::route('/'),
            'create' => Pages\CreateUserRole::route('/create'),
            'view' => Pages\ViewUserRole::route('/{record}'),
            'edit' => Pages\EditUserRole::route('/{record}/edit'),
        ];
    }
}
