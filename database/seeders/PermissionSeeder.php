<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
           "role-list",
           "role-create",
            "role-edit",
            "role-delete",
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",
            "department-list",
            "department-create",
            "department-edit",
            "department-delete",
        ];

        // Create permissions for 'web' guard (admin users)
        foreach ($permissions as $key=> $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Also create permissions for 'cooperative' guard (manager users)
        // Only create user and department permissions for cooperative guard
        $cooperativePermissions = [
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",
            "department-list",
            "department-create",
            "department-edit",
            "department-delete",
        ];

        foreach ($cooperativePermissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'cooperative'],
                ['name' => $permission, 'guard_name' => 'cooperative']
            );
        }
    }
}
