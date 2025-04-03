<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MarkUser;
use Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;

class UserSeeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run(): void
    {
        // Clear existing users
        DB::table('users')->truncate();
        DB::table('mark_users')->truncate();

        // Create regular users
        $this->createRegularUsers();

        // Create mark users
        $this->createMarkUsers();
    }

    /**
     * Create regular users
     *
     * @return void
     */
    private function createRegularUsers(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_active' => false,
                'email_verified_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }

    /**
     * Create mark users
     *
     * @return void
     */
    private function createMarkUsers(): void
    {
        $markUsers = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'password' => password_hash('editor123', PASSWORD_BCRYPT),
                'role' => 'editor',
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Contributor User',
                'email' => 'contributor@example.com',
                'password' => password_hash('contributor123', PASSWORD_BCRYPT),
                'role' => 'contributor',
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($markUsers as $userData) {
            MarkUser::create($userData);
        }
    }
}
