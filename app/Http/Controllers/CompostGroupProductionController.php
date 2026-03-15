<?php

namespace App\Http\Controllers;

use App\Models\Compost_group_production;
use App\Models\Group;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompostGroupProductionController extends Controller
{
    //
    public function index()
    {
        $title = "Compost Group";
        $CompostGroupProductions = Compost_group_production::orderBy('id', 'desc')->get();
        $groups= Group::orderBy('id','asc')->get();
        $seasons = Season::orderBy('id','asc')->get();
        return view('compost.index', compact('title', 'CompostGroupProductions', 'groups', 'seasons'));
    }



    // handle action
    public function handleAction(Request $request)
    {
        $request->validate([
            'action'             => 'required|in:INSERT,UPDATE,DELETE',
            'id'                 => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'group_id'           => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'season_id'          => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'material_type'      => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'production_start'   => 'nullable|required_if:action,INSERT,UPDATE|date',
            'production_end'     => 'nullable|date',
            'qty_produced_kg'    => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'estimated_value'    => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'status'             => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);

        DB::statement(
            'CALL sp_compost_group_productions_action(?,?,?,?,?,?,?,?,?,?)',
            [
                $request->action,            // p_action
                $request->id,                // p_id
                $request->group_id,          // p_group_id
                $request->season_id,         // p_season_id
                $request->material_type,     // p_material_type
                $request->production_start,  // p_production_start
                $request->production_end,    // p_production_end
                $request->qty_produced_kg,   // p_qty_produced_kg
                $request->estimated_value,   // p_estimated_value
                $request->status             // p_status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}
