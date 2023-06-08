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
                        'eng' => 'ტენტიანი',
                        'geo' => 'ტენტიანი',
                        'tur' => 'ტენტიანი',
                        'rus' => 'ტენტიანი'
                    ],
                    'key' => 'ტენტიანი',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'რეფრეჟერატორი',
                        'geo' => 'რეფრეჟერატორი',
                        'tur' => 'რეფრეჟერატორი',
                        'rus' => 'რეფრეჟერატორი'
                    ],
                    'key' => 'რეფრეჟერატორი',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'იზოთერმული',
                        'geo' => 'იზოთერმული',
                        'tur' => 'იზოთერმული',
                        'rus' => 'იზოთერმული'
                    ],
                    'key' => 'იზოთერმული',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'ბორტიანი',
                        'geo' => 'ბორტიანი',
                        'tur' => 'ბორტიანი',
                        'rus' => 'ბორტიანი'
                    ],
                    'key' => 'ბორტიანი',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'დაბალრამიანი',
                        'geo' => 'დაბალრამიანი',
                        'tur' => 'დაბალრამიანი',
                        'rus' => 'დაბალრამიანი'
                    ],
                    'key' => 'დაბალრამიანი',
                    'icon_default' => null,
                    'icon_hover' => null
                ],
                [
                    'title' => [
                        'eng' => 'პლატფორმა',
                        'geo' => 'პლატფორმა',
                        'tur' => 'პლატფორმა',
                        'rus' => 'პლატფორმა'
                    ],
                    'key' => 'პლატფორმა',
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
