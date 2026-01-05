<?php

namespace App\Http\Controllers\CoOperative;

use App\Http\Controllers\Controller;
use App\Models\CoOperative\CoUser;
use App\Models\department\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class CoUserController extends Controller
{
    //
    public function index()
    {
        $title = "Co-operative Users";
        $users = CoUser::all();
        $roles = Role::where('guard_name', 'cooperative')->get();
        return view('CoOperative.index', compact('title', 'users', 'roles'));
    }

    // view create co user form
    public function create()
    {
        $title = "Kwandika Unyamuryango wa Co-operative";
        $roles = Role::where('guard_name', 'cooperative')->get();
        $departments = Department::all();
        return view('CoOperative.create', compact('title', 'roles', 'departments'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // exit;
        // validate request
        $request->validate([
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:co_users,email',
            'username' => 'required|unique:co_users,username',
            'password' => 'required|min:6',
            'Department_id' => 'required',
            'roles' => 'required',
        ]);

        // create co user
        $user = CoUser::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            // 'roles' => $request->roles,
            'Department_id' => $request->Department_id,
            'status' => 'active',
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('cooperative.user')->with('success', 'Co-operative user created successfully!');
    }

    // view edit co user form
    public function edit($id)
    {
        $title = "Hindura Unyamuryango wa Co-operative";
        $user = CoUser::findOrFail($id);
        $roles = Role::where('guard_name', 'cooperative')->get();
        $departments = Department::all();
        return view('CoOperative.edit', compact('title', 'user', 'roles', 'departments'));
    }

    public function update(Request $request, $id)
{
    $user = CoUser::findOrFail($id);

    $validated = $request->validate([
        'full_name'     => 'required|string|max:255',
        'phone'         => 'required',
        'Department_id' => 'required|exists:departments,id',
        'roles'         => 'required',
    ]);

    $data = [
        'full_name'     => $validated['full_name'],
        'Department_id' => $validated['Department_id'],
        'phone'         => $validated['phone'],
    ];

    // Update password if provided
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);
    $user->syncRoles($request->roles);

    return back()->with('success', 'User updated successfully!');
}


    public function destroy($id)
    {
        $user = CoUser::findOrFail($id);
        $user->delete();

        return redirect()->route('cooperative.user')->with('success', 'Co-operative user deleted successfully!');
    }
}
