<?php

namespace Database\Seeders;

use App\Models\TrailerType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrailerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('trailer_types')->count()){
            $trailerTypes = [
                [
                    'title' => [
                        'eng' => 'Tautliner',
                        'geo' => 'ტენტიანი',
                        'tur' => 'ტენტიანი',
                        'rus' => 'ტენტიანი'
                    ],
                    'key' => 'tautliner',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Refrigerator',
                        'geo' => 'რეფრეჟერატორი',
                        'tur' => 'რეფრეჟერატორი',
                        'rus' => 'რეფრეჟერატორი'
                    ],
                    'key' => 'refrigerator',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Isotherm',
                        'geo' => 'იზოთერმული',
                        'tur' => 'იზოთერმული',
                        'rus' => 'იზოთერმული'
                    ],
                    'key' => 'isotherm',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Drop-side platform',
                        'geo' => 'ბორტიანი',
                        'tur' => 'ბორტიანი',
                        'rus' => 'ბორტიანი'
                    ],
                    'key' => 'drop-side',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Lowboy truck',
                        'geo' => 'დაბალრამიანი',
                        'tur' => 'დაბალრამიანი',
                        'rus' => 'დაბალრამიანი'
                    ],
                    'key' => 'lowboy',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'Container',
                        'geo' => 'პლატფორმა',
                        'tur' => 'პლატფორმა',
                        'rus' => 'პლატფორმა'
                    ],
                    'key' => 'container',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'ავტომზიდი',
                        'geo' => 'ავტომზიდი',
                        'tur' => 'ავტომზიდი',
                        'rus' => 'ავტომზიდი'
                    ],
                    'key' => 'ავტომზიდი',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
            ];

            foreach ($trailerTypes as $type){
                $carType = new TrailerType();
                $carType->setTranslations('title', $type['title']);
                $carType->key = $type['key'];
                $carType->icon_default = $type['icon_default'];
                $carType->icon_hover = $type['icon_hover'];

                $carType->save();
            }
        }

    }
}
