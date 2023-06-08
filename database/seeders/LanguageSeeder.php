<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('languages')->count()){
            $languages = [
                'English',
                'Turkish',
                'Russian',
                'ქართული'
            ];

            foreach ($languages as $lang){
                Language::create([
                    'title' => $lang
                ]);
            }
        }
    }
}
