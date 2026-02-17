<?php

namespace App\Http\Controllers;

use App\Models\CoOperative\CoUser;
use App\Models\Input_Allocation;
use App\Models\Member;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputAllocationController extends Controller
{
    //
    public function index()
    {
        $title = 'Input Allocation';
        $Members = Member::orderBy('created_at', 'DESC')->get();
        $Seasons = Season::orderBy('created_at', 'DESC')->get();
        $Users = CoUser::orderBy('created_at', 'DESC')->get();
        $InputAllocations = Input_Allocation::orderBy('created_at', 'DESC')->get();
        return view('input_allocation.index', compact('title', 'Members', 'Seasons', 'Users', 'InputAllocations'));
    }

    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'               => 'required|in:INSERT,UPDATE,DELETE',
            'id'                   => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'member_id'            => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'season_id'            => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'Type_'                => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'Quantity'             => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'Unit_Cost'            => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            // 'approved_by_manager'  => 'nullable|string|max:255',
            'Approval_Date'        => 'nullable|date',
            'Status'               => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);

         if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;
        try {
            // Call the stored procedure
            DB::statement(
                'CALL sp_input_allocations(?,?,?,?,?,?,?,?,?,?)',
                [
                    $request->action,              // p_action
                    $request->id,                  // p_id
                    $request->member_id,           // p_member_id
                    $request->season_id,           // p_season_id
                    $request->Type_,               // p_Type
                    $request->Quantity,            // p_Quantity
                    $request->Unit_Cost,           // p_Unit_Cost
                    $currentUserId, // p_approved_by_manager
                    $request->Approval_Date,       // p_Approval_Date
                    $request->Status               // p_Status
                ]
            );

            return back()->with('success', 'Action ' . $request->action . ' performed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error performing action: ' . $e->getMessage());
        }
    }
}
