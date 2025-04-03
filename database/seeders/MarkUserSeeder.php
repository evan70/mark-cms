<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;

class MarkUserSeeder
{
    public function run()
    {
        // Mark users
        Capsule::table('mark_users')->insert([
            [
                'name' => 'System Administrator',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'role' => 'admin',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Content Editor',
                'email' => 'editor@example.com',
                'password' => password_hash('editor123', PASSWORD_BCRYPT),
                'role' => 'editor',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Content Contributor',
                'email' => 'contributor@example.com',
                'password' => password_hash('contributor123', PASSWORD_BCRYPT),
                'role' => 'contributor',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
