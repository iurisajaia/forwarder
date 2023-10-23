<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'title' => 'GEL',
                'symbol' => '₾',
                'key' => 'GEL'
            ] ,
            [
                'title' => 'USD',
                'symbol' => '$',
                'key' => 'USD'
            ]
        ];
        if(!DB::table('currencies')->count()){
            foreach($currencies as $c){
                Currency::create($c);
            }
        }
    }
}
