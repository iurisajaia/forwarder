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
                    'title' => [
                        'en' => 'Standard',
                        'ka' => 'სტანდარტული'
                    ],
                    'key' => 'standard',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'en' => 'Legal entity',
                        'ka' => 'იურიდიული პირი'
                    ],
                    'key' => 'legal_entity',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'en' => 'Forwarder',
                        'ka' => 'ფორვარდერი'
                    ],
                    'key' => 'forwarder',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'en' => 'Driver',
                        'ka' => 'მძღოლი'
                    ],
                    'key' => 'driver',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'en' => 'Company customer',
                        'ka' => 'მომხმარებელი'
                    ],
                    'key' => 'company_customer',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'en' => 'Administrator',
                        'ka' => 'ადმინისტრატორი'
                    ],
                    'key' => 'administrator',
                    'is_visible' => false
                ],
                [
                    'title' => [
                        'en' => 'Moderator',
                        'ka' => 'მოდერატორი'
                    ],
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
