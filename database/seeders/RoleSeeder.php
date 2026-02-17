<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles for 'web' guard (admin users)
        $adminRole = Role::updateOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['name' => 'Admin', 'guard_name' => 'web']
        );
        
        // Assign all web permissions to Admin role
        $webPermissions = Permission::where('guard_name', 'web')->pluck('name')->toArray();
        $adminRole->syncPermissions($webPermissions);

        // Create roles for 'cooperative' guard (manager users)
        $managerRole = Role::updateOrCreate(
            ['name' => 'Manager', 'guard_name' => 'cooperative'],
            ['name' => 'Manager', 'guard_name' => 'cooperative']
        );
        
        // Assign all cooperative permissions to Manager role
        $cooperativePermissions = Permission::where('guard_name', 'cooperative')->pluck('name')->toArray();
        $managerRole->syncPermissions($cooperativePermissions);

        // Create a limited role for cooperative users
        $userRole = Role::updateOrCreate(
            ['name' => 'User', 'guard_name' => 'cooperative'],
            ['name' => 'User', 'guard_name' => 'cooperative']
        );
        
        // Assign limited permissions to User role (read-only for most modules)
        $userPermissions = [
            'group-list',
            'season-list',
            'plan-list',
            'field-activity-list',
            'member-list',
            'allocation-list',
            'riceDelivery-list',
        ];
        
        $userRole->syncPermissions($userPermissions);
    }
}
