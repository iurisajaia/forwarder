<?php

namespace Database\Seeders;

use App\Models\DangerStatus;
use App\Models\PackagingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackagingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('packaging_types')->count()){


            $types = ['pallet', 'box'];

            foreach ($types as $type){
                PackagingType::create([
                    'name' => $type
                ]);
            }
        }
    }
}
