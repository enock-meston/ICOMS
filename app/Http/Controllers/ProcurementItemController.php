<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Member_Payment;
use App\Models\Rice_Delivery;
use App\Models\Procurement_plan;
use App\Models\ProcurementItem;
use App\Models\department\Department;

class ProcurementItemController extends Controller
{
    //
    public function index()
    {
        $title = "Member Payments";
        $payments = Member_Payment::orderBy('id', 'asc')->get();
        $members = Member::orderBy('id', 'asc')->get();
        $deliveries = Rice_Delivery::orderBy('id', 'asc')->get();
        $ProcuPlan = Procurement_plan::orderBy('id', 'asc')->get();
        $ProcuItem = ProcurementItem::orderBy('id', 'asc')->get();
        $departments = Department::orderBy('id', 'asc')->get();
        return view('procurement-item.index', compact('title', 'members', 'payments','deliveries', 'ProcuPlan','ProcuItem', 'departments'));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:INSERT,UPDATE,DELETE',
            'id' => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'Procu_plan_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'department_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'description' => 'nullable|required_if:action,INSERT,UPDATE|string',
            'quantity' => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'unit_of_measure' => 'nullable|required_if:action,INSERT,UPDATE|string',
            'estimated_unit_cost' => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'estimated_total_cost' => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'procurement_method' => 'nullable|required_if:action,INSERT,UPDATE|string',
            'priority' => 'nullable|required_if:action,INSERT,UPDATE|string',
            'planned_tender_date' => 'nullable|required_if:action,INSERT,UPDATE|date',
            'status' => 'nullable|required_if:action,INSERT,UPDATE|string',
        ]);

        DB::statement(
            'CALL sp_procurement_items_action(?,?,?,?,?,?,?,?,?,?,?,?,?)',
            [
                $request->action,
                $request->id,
                $request->Procu_plan_id,
                $request->department_id,
                $request->description,
                $request->quantity,
                $request->unit_of_measure,
                $request->estimated_unit_cost,
                $request->estimated_total_cost,
                $request->procurement_method,
                $request->priority,
                $request->planned_tender_date,
                $request->status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' executed successfully!'
        );
    }
}
