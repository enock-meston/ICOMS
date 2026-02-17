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
        // All permissions for 'web' guard (admin users)
        $webPermissions = [
            // Role management
            "role-list",
            "role-create",
            "role-edit",
            "role-delete",
            
            // User management
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",
            
            // Department management
            "department-list",
            "department-create",
            "department-edit",
            "department-delete",
            
            // Group management
            "group-list",
            "group-create",
            "group-edit",
            "group-delete",
            
            // Season management
            "season-list",
            "season-create",
            "season-edit",
            "season-delete",
            
            // Production Plan management
            "plan-list",
            "plan-create",
            "plan-edit",
            "plan-delete",
            
            // Field Activity management
            "field-activity-list",
            "field-activity-create",
            "field-activity-edit",
            "field-activity-delete",
            
            // Member management
            "member-list",
            "member-create",
            "member-edit",
            "member-delete",
            
            // Input Allocation management
            "allocation-list",
            "allocation-create",
            "allocation-edit",
            "allocation-delete",
            
            // Rice Delivery management
            "riceDelivery-list",
            "riceDelivery-create",
            "riceDelivery-edit",
            "riceDelivery-delete",
            
            // Cooperative User management
            "cooperative-user-list",
            "cooperative-user-create",
            "cooperative-user-edit",
            "cooperative-user-delete",
        ];

        // Create permissions for 'web' guard (admin users)
        foreach ($webPermissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Permissions for 'cooperative' guard (manager users)
        // Cooperative users typically have limited permissions
        $cooperativePermissions = [
            // User management (cooperative users)
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",
            
            // Department management
            "department-list",
            "department-create",
            "department-edit",
            "department-delete",
            
            // Group management
            "group-list",
            "group-create",
            "group-edit",
            "group-delete",
            
            // Season management
            "season-list",
            "season-create",
            "season-edit",
            "season-delete",
            
            // Production Plan management
            "plan-list",
            "plan-create",
            "plan-edit",
            "plan-delete",
            
            // Field Activity management
            "field-activity-list",
            "field-activity-create",
            "field-activity-edit",
            "field-activity-delete",
            
            // Member management
            "member-list",
            "member-create",
            "member-edit",
            "member-delete",
            
            // Input Allocation management
            "allocation-list",
            "allocation-create",
            "allocation-edit",
            "allocation-delete",
            
            // Rice Delivery management
            "riceDelivery-list",
            "riceDelivery-create",
            "riceDelivery-edit",
            "riceDelivery-delete",
        ];

        // Create permissions for 'cooperative' guard
        foreach ($cooperativePermissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'cooperative'],
                ['name' => $permission, 'guard_name' => 'cooperative']
            );
        }
    }
}
