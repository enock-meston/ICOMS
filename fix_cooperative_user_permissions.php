<?php

/**
 * Script to verify and fix cooperative user (manager) permissions
 * Run: php fix_cooperative_user_permissions.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CoOperative\CoUser;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

// You can change this email to test with different users
$email = 'manager1@gmail.com';
$user = CoUser::where('email', $email)->first();

if (!$user) {
    echo "❌ Cooperative user with email {$email} not found!\n";
    echo "Please create the user first in the co_users table.\n";
    exit(1);
}

echo "✅ Cooperative user found: {$user->full_name} ({$user->email})\n";
echo "   Guard name: {$user->guard_name}\n\n";

// Check if 'manager' role exists for cooperative guard
$role = Role::where('name', 'manager')->where('guard_name', 'cooperative')->first();

if (!$role) {
    echo "⚠️  Role 'manager' for 'cooperative' guard not found. Creating it...\n";
    $role = Role::create(['name' => 'manager', 'guard_name' => 'cooperative']);
    echo "✅ Role 'manager' created for cooperative guard.\n\n";
} else {
    echo "✅ Role 'manager' found (guard: {$role->guard_name})\n\n";
}

// Check if user has the role
if (!$user->hasRole('manager')) {
    echo "⚠️  User doesn't have 'manager' role. Assigning...\n";
    $user->assignRole('manager');
    echo "✅ Role assigned.\n\n";
} else {
    echo "✅ User has 'manager' role.\n\n";
}

// Check permissions for cooperative guard
$requiredPermissions = ['user-list', 'user-create', 'user-edit', 'user-delete', 'department-list'];
$missingPermissions = [];

foreach ($requiredPermissions as $permName) {
    $permission = Permission::where('name', $permName)->where('guard_name', 'cooperative')->first();

    if (!$permission) {
        echo "⚠️  Permission '{$permName}' for 'cooperative' guard not found. Creating...\n";
        $permission = Permission::create(['name' => $permName, 'guard_name' => 'cooperative']);
        echo "✅ Permission '{$permName}' created for cooperative guard.\n";
        $missingPermissions[] = $permission;
    } else {
        echo "✅ Permission '{$permName}' exists (guard: {$permission->guard_name})\n";

        // Check if role has this permission
        if (!$role->hasPermissionTo($permName, 'cooperative')) {
            $missingPermissions[] = $permission;
        }
    }
}

// Assign missing permissions to role
if (!empty($missingPermissions)) {
    echo "\n⚠️  Assigning missing permissions to 'manager' role...\n";
    foreach ($missingPermissions as $perm) {
        $role->givePermissionTo($perm);
    }
    echo "✅ Permissions assigned to role.\n\n";
} else {
    echo "\n✅ All permissions are assigned to the role.\n\n";
}

// Clear cache
echo "🔄 Clearing permission cache...\n";
\Artisan::call('permission:cache-reset');
echo "✅ Cache cleared.\n\n";

// Final check
echo "📋 Final Verification:\n";
echo "   User roles: " . $user->roles->pluck('name')->join(', ') . "\n";
echo "   User permissions: " . $user->getAllPermissions()->pluck('name')->join(', ') . "\n";
echo "   Can 'user-list': " . ($user->can('user-list') ? '✅ YES' : '❌ NO') . "\n";
echo "   Can 'user-create': " . ($user->can('user-create') ? '✅ YES' : '❌ NO') . "\n";
echo "   Can 'user-edit': " . ($user->can('user-edit') ? '✅ YES' : '❌ NO') . "\n";
echo "   Can 'user-delete': " . ($user->can('user-delete') ? '✅ YES' : '❌ NO') . "\n";
echo "   Can 'department-list': " . ($user->can('department-list') ? '✅ YES' : '❌ NO') . "\n";

echo "\n✅ Done! Please try logging in again as the manager.\n";

