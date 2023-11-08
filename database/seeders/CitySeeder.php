<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'key' => 'Tbilisi',
                'title' => 'თბილისი'
            ],
            [
                "key" => "Batumi",
                "title" => 'ბათუმი'
            ],
            [
                "key" => "Kutaisi",
                "title" => 'ქუთაისი'
            ],
            [
                "key" => "Rustavi",
                "title" => 'რუსთავი'
            ],
            [
                "key" => 'Gori',
                "title" => 'გორი'
            ],
            [
                "key" => 'Zugdidi',
                "title" => 'ზუგდიდი'
            ],
            [
                "key" => "Poti",
                "title" => 'ფოთი'
            ],
            [
                "key" => "Kobuleti",
                "title" => 'ქობულეთი'
            ],
            [
                "key" => "Khashuri",
                "title" => 'ხაშური'
            ],
            [
                "key" => "Samtredia",
                "title" => 'სამტრედია'
            ],
            [
                "key" => "Senaki",
                "title" => 'სენაკი'
            ],
            [
                "key" => "Zestafoni",
                "title" => 'ზესტაფონი'
            ],
            [
                "key" => "Marneuli",
                "title" => 'მარნეული'
            ]
        ];

        if(!DB::table('cities')->count()){
            DB::table('cities')->insert($cities);
        }
    }
}
