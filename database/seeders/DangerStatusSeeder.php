<?php

namespace Database\Seeders;

use App\Models\DangerStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DangerStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('danger_statuses')->count()){


            $types = ['ADR 1', 'ADR 2', 'ADR 3', 'ADR 4', 'ADR 5', 'ADR 6', 'ADR 7', 'ADR 8', 'ADR 9', 'ADR 10'];

            foreach ($types as $type){
                DangerStatus::create([
                    'name' => $type
                ]);
            }
        }
    }
}
