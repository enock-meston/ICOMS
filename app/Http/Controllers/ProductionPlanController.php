<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\ProductionPlan;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionPlanController extends Controller
{
    public function index()
    {
        $title = "Plan";
        $ProductPlans = ProductionPlan::orderBy('created_at','DESC')->get();
        $Groups = Group::all();
        $Seasons = Season::all();
        return view('prod_plan.index', compact('title', 'ProductPlans', 'Groups', 'Seasons'));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'season_id' => 'required|exists:seasons,id',
            'action' => 'required|in:INSERT,UPDATE,DELETE',
        ]);

        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;


        DB::statement('CALL sp_plan_save(?,?,?,?,?,?,?,?,?)', [
            $request->action,
            $request->plan_id,
            $request->group_id,
            $request->season_id,
            $request->planned_area_ha,
            $request->planned_yield_tons,
            $request->planned_inputs_cost,
            $request->status,
            $currentUserId
        ]);

        return back()->with('success', 'Action ' . $request->action . ' performed successfully!');
    }
}
