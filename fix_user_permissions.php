<?php

/**
 * Script to verify and fix user permissions
 * Run: php fix_user_permissions.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

$email = 'manager1@gmail.com';
$user = User::where('email', $email)->first();

if (!$user) {
    echo "❌ User with email {$email} not found!\n";
    echo "Please create the user first.\n";
    exit(1);
}

echo "✅ User found: {$user->name} ({$user->email})\n";
echo "   Guard name: {$user->guard_name}\n\n";

// Check if 'manager' role exists
$role = Role::where('name', 'manager')->where('guard_name', 'web')->first();

if (!$role) {
    echo "⚠️  Role 'manager' not found. Creating it...\n";
    $role = Role::create(['name' => 'manager', 'guard_name' => 'web']);
    echo "✅ Role 'manager' created.\n\n";
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

// Check permissions
$requiredPermissions = ['user-list', 'user-create', 'user-edit', 'user-delete'];
$missingPermissions = [];

foreach ($requiredPermissions as $permName) {
    $permission = Permission::where('name', $permName)->where('guard_name', 'web')->first();

    if (!$permission) {
        echo "⚠️  Permission '{$permName}' not found. Creating...\n";
        $permission = Permission::create(['name' => $permName, 'guard_name' => 'web']);
        echo "✅ Permission '{$permName}' created.\n";
        $missingPermissions[] = $permission;
    } else {
        echo "✅ Permission '{$permName}' exists (guard: {$permission->guard_name})\n";

        // Check if role has this permission
        if (!$role->hasPermissionTo($permName)) {
            $missingPermissions[] = $permission;
        }
    }
}

// Assign missing permissions to role
if (!empty($missingPermissions)) {
    echo "\n⚠️  Assigning missing permissions to 'manager' role...\n";
    $role->givePermissionTo($missingPermissions);
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

echo "\n✅ Done! Please try logging in again.\n";

