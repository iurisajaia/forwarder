<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('user_roles')->count()){
            $userTypes = [
                [
                    'title' => 'Standard',
                    'key' => 'standard',
                    'is_visible' => true
                ],
                [
                    'title' => 'Legal entity',
                    'key' => 'legal_entity',
                    'is_visible' => true
                ],
                [
                    'title' => 'Forwarder',
                    'key' => 'forwarder',
                    'is_visible' => true
                ],
                [
                    'title' => 'Driver',
                    'key' => 'driver',
                    'is_visible' => true
                ],
                [
                    'title' => 'Company Customer',
                    'key' => 'company_customer',
                    'is_visible' => true
                ],
                [
                    'title' => 'Administrator',
                    'key' => 'administrator',
                    'is_visible' => false
                ],
                [
                    'title' => 'Moderator',
                    'key' => 'moderator',
                    'is_visible' => false
                ],


            ];

            foreach ($userTypes as $type){
                UserRole::create([
                    'title' => $type['title'],
                    'key' => $type['key'],
                    'is_visible' => $type['is_visible']
                ]);
            }
        }
    }
}
