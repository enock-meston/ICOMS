<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    //
    public function index()
    {
        $title = "Amatsinda";
        $groups = Group::all();
        return view('group.index', compact('title', 'groups'));
    }

    // view create co user form
    public function create()
    {
        $title = "Kwandika itsinda ";
        return view('group.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'district' => 'required',
            'Sector' => 'required',
            'cell' => 'required',
            'village' => 'required',
        ]);

        //looged in user id
        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;
        // dd($currentUserId);
        // exit();
        // create co group
        $group = Group::create([
            'name' => $request->name,
            'manager_id' => $currentUserId,
            'district' => $request->district,
            'Sector' => $request->Sector,
            'cell' => $request->cell,
            'village' => $request->village,
            'status' => 'active',
        ]);

        return back()->with('success', 'Group created successfully!');
    }


    public function edit($id)
    {
        $title = "Hindura itsinda";
        $group = Group::findOrFail($id);
        return view('group.edit', compact('title', 'group'));
    }

    public function update(Request $request, Group $group)
    {
        // 1. Validate input
        $validated = $request->validate([
            'name' => 'required',
            'district' => 'required',
            'cell' => 'required',
            'village' => 'required',
        ]);
         if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;

        $data = [
            'name' => $request->name,
            'manager_id' => $currentUserId,
            'district' => $request->district,
            'Sector' => $request->Sector,
            'cell' => $request->cell,
            'village' => $request->village,
            'status' => 'active',
        ];



            $group->update($data);

        return back()->with('success', 'Group updated successfully!');
    }

    public function destroy($id)
    {
        $user = Group::findOrFail($id);
        $user->delete();

        return redirect()->route('group.index')->with('success', 'group deleted successfully!');
    }
}
