<?php

namespace Database\Seeders;

use App\Models\CarType;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('car_types')->count()){
            $carTypes = [
                [
                    'title' => [
                        'en' => 'Sedan',
                        'ka' => 'სედანი'
                    ],
                    'key' => 'sedan',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'en' => 'Truck',
                        'ka' => 'სატვირთო'
                    ],
                    'key' => 'truck',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'en' => 'Wagon',
                        'ka' => 'მისაბმელი'
                    ],
                    'key' => 'wagon',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'en' => 'Coupe',
                        'ka' => 'კუპე'
                    ],
                    'key' => 'coupe',
                    'icon_default' => null,
                    'icon_hover' => null
                ]
            ];

            foreach ($carTypes as $type){
                $carType = new CarType();
                $carType->setTranslations('title', $type['title']);
                $carType->key = $type['key'];
                $carType->icon_default = $type['icon_default'];
                $carType->icon_hover = $type['icon_hover'];

                $carType->save();
            }
        }

    }
}
