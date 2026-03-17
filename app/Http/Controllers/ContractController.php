<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\department\Department;
use App\Models\Member_Payment;
use App\Models\Member;
use App\Models\Procurement_plan;
use App\Models\ProcurementItem;
use App\Models\Rice_Delivery;
use App\Models\Supplier;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    //
       public function index()
    {
        $title = "Contracts";
        $payments = Member_Payment::orderBy('id', 'asc')->get();
        $members = Member::orderBy('id', 'asc')->get();
        $deliveries = Rice_Delivery::orderBy('id', 'asc')->get();
        $ProcuPlan = Procurement_plan::orderBy('id', 'asc')->get();
        $ProcuItem = ProcurementItem::orderBy('id', 'asc')->get();
        $departments = Department::orderBy('id', 'asc')->get();
        $contracts = Contract::orderBy('id', 'asc')->get();
        $tenders = Tender::orderBy('id', 'asc')->get();
        $suppliers = Supplier::orderBy('id', 'asc')->get();
        return view('contract.index', compact('title',
                'members',
                'payments',
                'deliveries',
                'ProcuPlan',
                'ProcuItem',
                'departments',
                'contracts',
                'tenders',
                'suppliers'
                ));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:INSERT,UPDATE,DELETE',
            'id' => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'tender_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'supplier_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'contract_no' => 'nullable|required_if:action,INSERT,UPDATE|string',
            'description' => 'nullable|string',
            'contract_amount' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'signed_by_manager' => 'nullable|integer',
            'signed_at' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }

        $currentUserId = $currentUser->id;
        DB::statement('CALL sp_contracts_action(?,?,?,?,?,?,?,?,?,?,?,?)', [
            $request->action,
            $request->id,
            $request->tender_id,
            $request->supplier_id,
            $request->contract_no,
            $request->description,
            $request->contract_amount,
            $request->start_date,
            $request->end_date,
            $request->signed_by_manager ?? $currentUserId,
            $request->signed_at,
            $request->status
        ]);

        return back()->with('success', 'Action ' . $request->action . ' executed successfully!');
    }
}
