<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
        // examples:
        // $this->middleware(['permission:role-create'], ['only' => ['create','store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Roles Management";
        $roles = Role::all();
        // Get permissions for both guards
        $webPermissions = Permission::where('guard_name', 'web')->get();
        $cooperativePermissions = Permission::where('guard_name', 'cooperative')->get();
        $permissions = Permission::all();
        return view('admin.roles', compact('roles','permissions', 'webPermissions', 'cooperativePermissions', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = "Permission Management";
        $permissions = Permission::where('guard_name', 'web')->get();
        return view('admin.permission', compact('permissions', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,NULL,id,guard_name,' . $request->guard_name,
            'guard_name' => 'required|in:web,cooperative',
        ]);

        $guardName = $request->guard_name ?? 'web';
        $role = Role::create(['name' => $request->name, 'guard_name' => $guardName]);

        // Only sync permissions that match the guard_name
        if ($request->permissions) {
            $permissionNames = array_keys($request->permissions);
            $validPermissions = Permission::whereIn('name', $permissionNames)
                ->where('guard_name', $guardName)
                ->pluck('name')
                ->toArray();
            $role->syncPermissions($validPermissions);
        }

        return back()->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id . ',id,guard_name,' . $request->guard_name,
            'guard_name' => 'required|in:web,cooperative',
        ]);

        $guardName = $request->guard_name ?? $role->guard_name;
        $role->update([
            'name' => $request->name,
            'guard_name' => $guardName,
        ]);

        // Only sync permissions that match the guard_name
        if ($request->permissions) {
            $permissionNames = array_keys($request->permissions);
            $validPermissions = Permission::whereIn('name', $permissionNames)
                ->where('guard_name', $guardName)
                ->pluck('name')
                ->toArray();
            $role->syncPermissions($validPermissions);
        } else {
            $role->syncPermissions([]);
        }

        return back()->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
