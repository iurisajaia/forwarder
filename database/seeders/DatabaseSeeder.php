<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserRoleSeeder::class,
            CarTypeSeeder::class,
            LanguageSeeder::class,
            TrailerTypeSeeder::class,
            DealSeeder::class,
            DangerStatusSeeder::class,
            PackagingTypeSeeder::class,
            CurrencySeeder::class,
            CitySeeder::class
        ]);
    }
}
