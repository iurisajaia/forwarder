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
                    'icon' => null
                ],
                [
                    'title' => [
                        'en' => 'Truck',
                        'ka' => 'სატვირთო'
                    ],
                    'key' => 'truck',
                    'icon' => null
                ],
                [
                    'title' => [
                        'en' => 'Wagon',
                        'ka' => 'მისაბმელი'
                    ],
                    'key' => 'wagon',
                    'icon' => null
                ],
                [
                    'title' => [
                        'en' => 'Coupe',
                        'ka' => 'კუპე'
                    ],
                    'key' => 'coupe',
                    'icon' => null
                ]
            ];

            foreach ($carTypes as $type){
                $carType = new CarType();
                $carType->setTranslations('title', $type['title']);
                $carType->key = $type['key'];
                $carType->icon = $type['icon'];

                $carType->save();
            }
        }

    }
}
