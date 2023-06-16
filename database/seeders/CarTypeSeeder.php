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
                    'key' => 'memu',
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
