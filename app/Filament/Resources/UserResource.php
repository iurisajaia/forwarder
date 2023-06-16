<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Car;
use App\Models\DriverUserDetails;
use App\Models\Trailer;
use App\Models\User;
use App\Models\UserRole;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Closure;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';


    protected function handleRecordUpdate(array $data): Model
    {
        $record =  static::getModel()::update($data);
//        $record->driver()->create($data['detail']);

        return $record;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name'),
                    TextInput::make('email'),
                    TextInput::make('phone'),
                    Select::make('user_role_id')
                        ->relationship('role', 'title')
                        ->preload()
                        ->required()
                        ->reactive(),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->hidden(fn (Closure $get) => $get('user_role_id') !== 6),
                ]),
                Card::make([
                    TextInput::make('lastName'),
                    TextInput::make('private_number'),
                    TextInput::make('position'),
                ])
                ->relationship('standard')
                ->visible(fn (Closure $get) => $get('user_role_id') === 1),

                // driver
                Card::make([
                Card::make([
                    TextInput::make('telegram'),
                    TextInput::make('whatsapp'),
                    TextInput::make('viber'),
                    TextInput::make('referral_code'),
                    TextInput::make('iban'),
                ])
                ->relationship('driver')
                ->visible(fn (Closure $get) => $get('user_role_id') === 4),

                Select::make('languages')
                    ->relationship('languages', 'title')
                    ->preload()
                    ->multiple()
                    ->required()
                    ->reactive(),

                Card::make([
                    Select::make('car_id')
                        ->label('Car')
                        ->searchable()
                        ->options(function(callable $get){
                            return Car::pluck('number', 'id');
                        })
                        ->reactive()
                ])->relationship('driver'),
                    Card::make([
                        Select::make('trailer_id')
                            ->label('Trailer')
                            ->searchable()
                            ->options(function(callable $get){
                                return Trailer::pluck('title', 'id');
                            })
                            ->reactive()
                    ])->relationship('driver'),

                SpatieMediaLibraryFileUpload::make('drivers_license')
                    ->collection('drivers_license')
                    ->multiple()
                    ->enableReordering(),
                SpatieMediaLibraryFileUpload::make('passport')
                    ->multiple()
                    ->collection('passport')
                    ->enableReordering()
            ])
                ->visible(fn (Closure $get) => $get('user_role_id') === 4),

                // legal entity
                Card::make([
                    TextInput::make('identification_code'),
                    TextInput::make('company_name'),
                    TextInput::make('company_ceo_name'),
                    TextInput::make('contact_number')
                ])
                    ->relationship('legal')
                    ->visible(fn (Closure $get) => $get('user_role_id') === 2),
                Card::make([
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('residence_confirmation')
                            ->collection('residence_confirmation')
                            ->multiple()
                            ->enableReordering()
                    ]),
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('bank_credentials')
                            ->multiple()
                            ->collection('bank_credentials')
                            ->enableReordering()
                    ]),
                ])->visible(fn (Closure $get) => $get('user_role_id') === 2),


                // forwarder
                Card::make([
                    TextInput::make('identification_code'),
                    TextInput::make('company_name'),
                    TextInput::make('company_ceo_name'),
                    TextInput::make('contact_number')
                ])
                    ->relationship('forwarder')
                    ->visible(fn (Closure $get) => $get('user_role_id') === 3),
                Card::make([
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('residence_confirmation')
                            ->collection('residence_confirmation')
                            ->multiple()
                            ->enableReordering()
                    ]),
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('bank_credentials')
                            ->multiple()
                            ->collection('bank_credentials')
                            ->enableReordering()
                    ]),
                ])->visible(fn (Closure $get) => $get('user_role_id') === 3),

                // customer
                Card::make([
                    TextInput::make('identification_code'),
                    TextInput::make('company_name'),
                    TextInput::make('company_ceo_name'),
                    TextInput::make('contact_number')
                ])
                    ->relationship('customer')
                    ->visible(fn (Closure $get) => $get('user_role_id') === 5),
                Card::make([
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('residence_confirmation')
                            ->collection('residence_confirmation')
                            ->multiple()
                            ->enableReordering()
                    ]),
                    Card::make([
                        SpatieMediaLibraryFileUpload::make('bank_credentials')
                            ->multiple()
                            ->collection('bank_credentials')
                            ->enableReordering()
                    ]),
                ])->visible(fn (Closure $get) => $get('user_role_id') === 5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('role.title'),
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
            RelationManagers\RoleRelationManager::class,
            RelationManagers\LanguagesRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
