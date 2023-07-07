<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\RelationManagers;
use App\Models\Car;
use App\Models\DriverUserDetails;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('number')->required(),
                TextInput::make('title'),
                TextInput::make('model'),
                TextInput::make('identification_number'),
                Select::make('car_type_id')
                    ->relationship('type', 'title')
                    ->preload()
                    ->required()
                    ->reactive(),
                Card::make([
                    SpatieMediaLibraryFileUpload::make('tech_passport')
                        ->multiple()
                        ->collection('tech_passport')
                        ->enableReordering()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('model'),
                TextColumn::make('number'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'view' => Pages\ViewCar::route('/{record}'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
