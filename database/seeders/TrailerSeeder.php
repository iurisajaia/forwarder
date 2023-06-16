<?php

namespace Database\Seeders;

use App\Models\Trailer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrailerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('trailers')->count()){
            $trailers = [
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

            foreach ($trailers as $trailer){
                $tr = new Trailer();
                $tr->setTranslations('title', $trailer['title']);
                $tr->key = $trailer['key'];
                $tr->icon_default = $trailer['icon_default'];
                $tr->icon_hover = $trailer['icon_hover'];

                $tr->save();
            }
        }

    }
}
