<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarTypeResource\Pages;
use App\Filament\Resources\CarTypeResource\RelationManagers;
use App\Models\CarType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Concerns\Translatable;

class CarTypeResource extends Resource
{

    use Translatable;

    protected static ?string $model = CarType::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';


    public static function getTranslatableLocales(): array
    {
        return ['en', 'ka'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('key')->nullable(),
                FileUpload::make('icon_default')->nullable(),
                FileUpload::make('icon_hover')->nullable()
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
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarTypes::route('/'),
            'create' => Pages\CreateCarType::route('/create'),
            'view' => Pages\ViewCarType::route('/{record}'),
            'edit' => Pages\EditCarType::route('/{record}/edit'),
        ];
    }
}
