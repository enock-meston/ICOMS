<?php

namespace App\Http\Controllers;

use App\Models\CoOperative\CoUser;
use App\Models\Member_Payment;
use App\Models\Member;
use App\Models\Procurement_plan;
use App\Models\Rice_Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementPlanController extends Controller
{
    //
    public function index()
    {
        $title = "Member Payments";
        $payments = Member_Payment::orderBy('id', 'asc')->get();
        $members = Member::orderBy('id', 'asc')->get();
        $deliveries = Rice_Delivery::orderBy('id', 'asc')->get();
        $plans = Procurement_plan::orderBy('id', 'asc')->get();
        $Users = CoUser::orderBy('id','asc')->get();
        return view('procurement-plan.index', compact('title', 'members', 'payments', 'deliveries','plans','Users'));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:INSERT,UPDATE,DELETE',
            'id' => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'fiscal_year' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'approved_by_manager' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'approved_by_board' => 'nullable|required_if:action,INSERT,UPDATE|string',
            'approval_date' => 'nullable|required_if:action,INSERT,UPDATE|date',
            'status' => 'nullable|required_if:action,INSERT,UPDATE|string',
        ]);
        
        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }

        $currentUserId = $currentUser->id;
        DB::statement(
            'CALL sp_procurement_plans_action(?,?,?,?,?,?,?,?)',
            [
                $request->action,
                $request->id,
                $request->fiscal_year,
                $currentUserId,
                $request->approved_by_manager,
                $request->approved_by_board,
                $request->approval_date,
                $request->status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' executed successfully!'
        );
    }
}
