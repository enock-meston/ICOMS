<?php

namespace App\Http\Controllers;

use App\Models\FieldActivity;
use App\Models\ProductionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FieldActivityController extends Controller
{
    //
    public function index()
    {
        $title = 'Field activity';
        $FieldActivities = FieldActivity::orderBy('id', 'asc')->get();
        $ProductPlan = ProductionPlan::orderBy('created_at', 'desc')->get();
        return view('field-activity.index', compact('title', 'FieldActivities', 'ProductPlan'));
    }


    public function handleAction(Request $request)
    {
        $request->validate([
            'action'           => 'required|in:INSERT,UPDATE,DELETE',
            'id'               => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'plan_id'          => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'activity_type'    => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'planned_date'     => 'nullable|required_if:action,INSERT,UPDATE|date',
            'actual_date'      => 'nullable|date',
            'status'           => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);

        // Detect authenticated user (web or cooperative)
        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }

        $currentUserId = $currentUser->id;

        DB::statement(
            'CALL sp_field_activities(?,?,?,?,?,?,?,?)',
            [
                $request->action,                 // p_action
                $request->id,                     // p_id
                $request->plan_id,                // p_plan_id
                $request->activity_type,          // p_activity_type
                $request->planned_date,           // p_planned_date
                $request->actual_date,            // p_actual_date
                $currentUserId,                   // p_officer_user_id
                $request->status                  // p_status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}
