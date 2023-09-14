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
                        'eng' => 'Tractor unit',
                        'geo' => 'უნაგირა საწევარი',
                        'tur' => 'უნაგირა საწევარი',
                        'rus' => 'უნაგირა საწევარი'
                    ],
                    'id' => 1,
                    'key' => 'tractor-unit',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Tipper Trucks',
                        'geo' => 'თვითმცლელი',
                        'tur' => 'თვითმცლელი',
                        'rus' => 'თვითმცლელი'
                    ],
                    'id' => 2,
                    'key' => 'tipper-trucks',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Tank Truck',
                        'geo' => 'ცისტერნა',
                        'tur' => 'ცისტერნა',
                        'rus' => 'ცისტერნა'
                    ],
                    'id' => 3,
                    'key' => 'tank-truck',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Car Transporter',
                        'geo' => 'ავტომზიდი',
                        'tur' => 'ავტომზიდი',
                        'rus' => 'ავტომზიდი'
                    ],
                    'id' => 4,
                    'key' => 'car-transporter',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Open Platform Truck',
                        'geo' => 'ღია ბორტიანი',
                        'tur' => 'ღია ბორტიანი',
                        'rus' => 'ღია ბორტიანი'
                    ],
                    'id' => 5,
                    'key' => 'open-platform-truck',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Container Truck',
                        'geo' => 'კონტეინერმზიდი',
                        'tur' => 'კონტეინერმზიდი',
                        'rus' => 'კონტეინერმზიდი'
                    ],
                    'id' => 6,
                    'key' => 'container-truck',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Box Truck',
                        'geo' => 'ბოქსი',
                        'tur' => 'ბოქსი',
                        'rus' => 'ბოქსი'
                    ],
                    'id' => 7,
                    'key' => 'box-truck',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'A semi-trailer truck',
                        'geo' => 'ტენტიანი',
                        'tur' => 'ტენტიანი',
                        'rus' => 'ტენტიანი'
                    ],
                    'id' => 8,
                    'key' => 'semi-trailer-truck',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Chiller Trucks',
                        'geo' => 'მაცივარი',
                        'tur' => 'მაცივარი',
                        'rus' => 'მაცივარი'
                    ],
                    'id' => 9,
                    'key' => 'chiller-trucks',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Isotherm Truck',
                        'geo' => 'იზოთერმული',
                        'tur' => 'იზოთერმული',
                        'rus' => 'იზოთერმული'
                    ],
                    'id' => 10,
                    'key' => 'isotherm-truck',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Livestock Trucks',
                        'geo' => 'პირუტყვმზიდი',
                        'tur' => 'პირუტყვმზიდი',
                        'rus' => 'პირუტყვმზიდი'
                    ],
                    'id' => 11,
                    'key' => 'livestock-trucks',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Logging Trucks',
                        'geo' => 'ხეების მზიდი',
                        'tur' => 'ხეების მზიდი',
                        'rus' => 'ხეების მზიდი'
                    ],
                    'id' => 12,
                    'key' => 'logging-trucks',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Memu',
                        'geo' => 'Memu',
                        'tur' => 'Memu',
                        'rus' => 'Memu'
                    ],
                    'id' => 13,
                    'key' => 'memu',
                    'icon_default' => null,
                    'icon_hover' => null
                ]
            ];

            foreach ($carTypes as $type){
                $carType = new CarType();
                $carType->setTranslations('title', $type['title']);
                $carType->key = $type['key'];
                $carType->id = $type['id'];
                $carType->icon_default = $type['icon_default'];
                $carType->icon_hover = $type['icon_hover'];

                $carType->save();
            }
        }

    }
}
