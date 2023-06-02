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
                        'eng' => 'Sedan',
                        'geo' => 'სედანი',
                        'tur' => 'სედანი',
                        'rus' => 'სედანი'
                    ],
                    'key' => 'sedan',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Truck',
                        'geo' => 'სატვირთო',
                        'tur' => 'სატვირთო',
                        'rus' => 'სატვირთო'
                    ],
                    'key' => 'truck',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Wagon',
                        'geo' => 'მისაბმელი',
                        'tur' => 'მისაბმელი',
                        'rus' => 'მისაბმელი'
                    ],
                    'key' => 'wagon',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Coupe',
                        'geo' => 'კუპე',
                        'tur' => 'კუპე',
                        'rus' => 'კუპე'
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
