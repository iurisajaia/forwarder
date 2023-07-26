<?php

namespace Database\Seeders;

use App\Models\Deal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('deals')->count() && DB::table('users')->count()){

            for ($i = 0; $i < 20; $i++) {
                Deal::create([
                    'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
                ]);
            }
        }
    }
}
