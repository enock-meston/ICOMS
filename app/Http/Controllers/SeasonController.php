<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    //
    public function index()
    {
        $title = "icyiciro cy'ihinga";
        $seasons = Season::all();
        return view('season.index', compact('title', 'seasons'));
    }

    // view create co user form
    public function create()
    {
        $title = "Kwandika icyiciro cy'ihinga";
        return view('season.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'Start_Date' => 'required',
            'End_Date' => 'required',
            'status' => 'required',
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
        // create co season
        $season = Season::create([
            'name' => $request->name,
            'manager_id' => $currentUserId,
            'Start_Date'=>$request->Start_Date,
            'End_Date'=>$request->End_Date,
            'status' => 'PLANNED',
        ]);

        return back()->with('success', 'season created successfully!');
    }


    public function edit($id)
    {
        $title = "Hindura icyiciro cy'ihinga";
        $season = Season::findOrFail($id);
        return view('season.edit', compact('title', 'season'));
    }

    public function update(Request $request, Season $season)
    {
        // 1. Validate input
        $validated = $request->validate([
            'name' => 'required',
            'Start_Date' => 'required',
            'End_Date' => 'required',
            'status' => 'required',
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
            'End_Date' => $request->Sector,
            'Start_Date' => $request->cell,
            'status' => $request->status
        ];



            $season->update($data);

        return back()->with('success', 'season updated successfully!');
    }

    public function destroy($id)
    {
        $user = Season::findOrFail($id);
        $user->delete();

        return redirect()->route('season.index')->with('success', 'season deleted successfully!');
    }
}
