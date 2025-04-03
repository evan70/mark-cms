<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class LanguagesSeeder
{
    public function run()
    {
        Capsule::table('languages')->insert([
            [
                'code' => 'sk',
                'name' => 'Slovenčina',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'code' => 'cs',
                'name' => 'Čeština',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}