<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class AdminUsersSeeder
{
    public function run()
    {
        // Admin users
        Capsule::table('admin_users')->insert([
            [
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'name' => 'System Administrator',
                'role' => 'admin',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'email' => 'editor@example.com',
                'password' => password_hash('editor123', PASSWORD_BCRYPT),
                'name' => 'Content Editor',
                'role' => 'editor',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        // Permissions
        $permissions = [
            ['name' => 'manage_articles', 'description' => 'Create, edit and delete articles'],
            ['name' => 'manage_categories', 'description' => 'Create, edit and delete categories'],
            ['name' => 'manage_tags', 'description' => 'Create, edit and delete tags'],
            ['name' => 'manage_users', 'description' => 'Manage admin users'],
            ['name' => 'manage_settings', 'description' => 'Manage site settings']
        ];

        foreach ($permissions as $permission) {
            Capsule::table('admin_permissions')->insert($permission);
        }

        // Role permissions
        $adminPermissions = range(1, 5); // All permissions
        $editorPermissions = range(1, 3); // Only content management permissions

        // Admin role permissions
        foreach ($adminPermissions as $permissionId) {
            Capsule::table('admin_role_permissions')->insert([
                'role' => 'admin',
                'permission_id' => $permissionId
            ]);
        }

        // Editor role permissions
        foreach ($editorPermissions as $permissionId) {
            Capsule::table('admin_role_permissions')->insert([
                'role' => 'editor',
                'permission_id' => $permissionId
            ]);
        }
    }
}
