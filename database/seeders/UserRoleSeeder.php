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
                        'eng' => 'Standard',
                        'geo' => 'სტანდარტული',
                        'tur' => 'სტანდარტული',
                        'rus' => 'სტანდარტული'
                    ],
                    'key' => 'standard',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'eng' => 'Legal entity',
                        'geo' => 'იურიდიული პირი',
                        'tur' => 'იურიდიული პირი',
                        'rus' => 'იურიდიული პირი'
                    ],
                    'key' => 'legal_entity',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'eng' => 'Forwarder',
                        'geo' => 'ფორვარდერი',
                        'tur' => 'ფორვარდერი',
                        'rus' => 'ფორვარდერი'
                    ],
                    'key' => 'forwarder',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'eng' => 'Driver',
                        'geo' => 'მძღოლი',
                        'tur' => 'მძღოლი',
                        'rus' => 'მძღოლი'
                    ],
                    'key' => 'driver',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'eng' => 'Company customer',
                        'geo' => 'მომხმარებელი',
                        'tur' => 'მომხმარებელი',
                        'rus' => 'მომხმარებელი'
                    ],
                    'key' => 'company_customer',
                    'is_visible' => true
                ],
                [
                    'title' => [
                        'eng' => 'Administrator',
                        'geo' => 'ადმინისტრატორი',
                        'tur' => 'ადმინისტრატორი',
                        'rus' => 'ადმინისტრატორი'
                    ],
                    'key' => 'administrator',
                    'is_visible' => false
                ],
                [
                    'title' => [
                        'eng' => 'Moderator',
                        'geo' => 'მოდერატორი',
                        'tur' => 'მოდერატორი',
                        'rus' => 'მოდერატორი'
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
